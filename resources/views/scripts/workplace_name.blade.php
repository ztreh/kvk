$('#work_places_id').select2({
          tags: true,
          placeholder: "Select Workplace Name",
          minimumInputLength: 1,
          ajax: {
              url: '{{url("workpalces")}}',
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