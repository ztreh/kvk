 $('#salary_session_types_id').select2({
          tags: true,
          placeholder: "Select Salary Session Types",
          minimumInputLength: 1,
          ajax: {
              url: '{{url("autocomplete/salarysessiontype")}}',
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