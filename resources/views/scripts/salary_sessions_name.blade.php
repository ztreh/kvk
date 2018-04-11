$('#salary_sessions_id').select2({
          tags: true,
          placeholder: "Select Salary Session",
          minimumInputLength: 1,
          ajax: {
              url: '{{url("autocomplete/salary__sessions/1")}}',
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
              cache: true,

             
          }
      });