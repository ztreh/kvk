 $('#salary_session_types_id').select2({
          tags: true,
          placeholder: "Select Salary Session Types",
          minimumInputLength: 1,
          ajax: {
              url: '{{url("autocomplete/salary__session__types/1")}}',
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