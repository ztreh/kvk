
  $('#salary_session_work_places_id').select2({
      tags: true,
      placeholder: "Select Workplace  Salary Session ",
      minimumInputLength: 1,
      ajax: {
          url: '{{url("salary_session_work_places")}}',
          dataType: 'json',
          data: function (params) {
              return {
                  q: $.trim(params.term)
              };
          },
          processResults: function (data) {
              return {
                  results: data
              };
          },
          cache: true
      }
  });
  
