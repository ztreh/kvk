<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\SalarySessionWorkPlace;
use Fpdf;

class Advance extends Model
{
    protected $fillable = ['salary_session_work_places_id','employees_id','advance_amount'];

    public function employees() {
        return $this->belongsTo('App\Employee');
    }
	public function salary_session_work_places(){
        return $this->belongsTo('App\SalarySessionWorkPlace');

	}
    
    public function insertData(Request $request,$id=0)
    {
        if($id>0){
            $this->update($request->all()); 
        }else{
            $this->save();
        }
    }

    public function getAllAdvancePayments($id=0)
    {
    	$advance_array=array();
    	if($id>0){
    		$advances=$this->where('id',$id)->get();
    	}else{
    		$advances=$this->all();
    	}
    	
    	$salary_session_work_place=new SalarySessionWorkPlace;
    	foreach ($advances as $key => $value) {
    		$advance_array[$key]['id']=$value['id'];
    		$advance_array[$key]['advance_amount']=$value['advance_amount'];
    		$advance_array[$key]['created_at']=$value['created_at'];
    		$advance_array[$key]['salary_session_work_places_id']=$value['salary_session_work_places_id'];
    		$advance_array[$key]['employees_id']=$value['employees_id'];
    		$advance_array[$key]['employee_name']=$value->employees->name;
    		$advance_array[$key]['salary_session_work_place_details']=$salary_session_work_place->getDetails($value['salary_session_work_places_id']);
    	}

    	return $advance_array;
    }
    public function printAdvance($id=0)
    {
    	
    	$advance=$this->getAllAdvancePayments($id)[0];
    	
    	$line_height=5;
    	Fpdf::AddPage('P');
    	Fpdf::SetFont('Arial','B',12);
    	
    	Fpdf::Cell(100,$line_height*2,'KVK Motors - Advance Payment','T,L,R',0,'C');

    	Fpdf::Ln();
    	Fpdf::SetFont('Arial','',10);
    	Fpdf::Cell(100,5,ucfirst($advance['salary_session_work_place_details']),'L,R',0,'C');
    	Fpdf::Ln();
    	Fpdf::SetFont('Arial','',10);

    	Fpdf::Cell(100,$line_height,'Employee Name:','T,L,R',0,'L');
    	Fpdf::Ln();

    	Fpdf::Cell(100,$line_height,$advance['employee_name'],'L,R',0,'C');
    	
    	Fpdf::Ln();
    	
    	Fpdf::Cell(100,$line_height,'Amount : Rs.'.number_format($advance['advance_amount'],2)." /=",'L,R',0,'L');
    	Fpdf::Ln();
    	
    	Fpdf::Cell(100,$line_height,'Date Issued : '.($advance['created_at']),'L,R,B',0,'L');
    	Fpdf::SetFont('Arial','B',10);
    	
    	Fpdf::Ln();
    	Fpdf::Cell(50,$line_height*2,'','L',0,'C');
    	Fpdf::Cell(50,$line_height*2,'','R',0,'C'); 
    	Fpdf::Ln();
    	Fpdf::Cell(50,$line_height,'...............................','L',0,'C');
    	Fpdf::Cell(50,$line_height,'...............................','R',0,'C'); 
    	Fpdf::Ln();
    	Fpdf::Cell(50,$line_height,'Prepared By','L',0,'C');
    	Fpdf::Cell(50,$line_height,'Received By','R',0,'C'); 

    	Fpdf::Ln();
    	Fpdf::Cell(100,$line_height,'','L,R',0,'C'); 
    	Fpdf::Ln();
    	Fpdf::Cell(100,$line_height,'......................','L,R',0,'C');
    	Fpdf::Ln();
    	Fpdf::Cell(100,$line_height,'Authorized By','L,R,B',0,'C');
    	Fpdf::Output();
    	exit;
    }
}
