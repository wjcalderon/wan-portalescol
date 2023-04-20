(function ($, Drupal) {
  const urlFormat = drupalSettings.formatUrl;

  const formatDateFilter = (date) => {
    // Day
    let day = date.getDate();
    if (day < 10) day = `0${day}`;

    // Month
    let month = date.getMonth() + 1;
    if (month < 10) month = `0${month}`;

    // Year
    let year = date.getFullYear();
    if (year < 10) year = `0${year}`;

    // Hour
    // let hour = date.getHours();
    // if(hour < 10) hour = `0${hour}`;

    // // Minutes
    // let minutes = date.getMinutes();
    // if(minutes < 10) minutes = `0${minutes}`;

    // // Seconds
    // let seconds = date.getSeconds();
    // if(seconds < 10) seconds = `0${seconds}`;

    // return `${day}-${month}-${year} ${hour}:${minutes}:${seconds}`;
    return `${day}-${month}-${year}`;
  };

  const getDrupalFormattedDate = (date, filter, callback) => {
    // const dateString = formatDateFilter(date);

    const args = {
      date: date,
    };
    $.ajax({
      beforeSend: function (xhrObj) {
        xhrObj.setRequestHeader("Content-Type", "application/json");
        xhrObj.setRequestHeader("Accept", "application/json");
      },
      type: "POST",
      url: urlFormat,
      async: false,
      data: JSON.stringify(args),
      dataType: "json",
      processData: false,
      success: function (response) {
        callback(filter, response.formatted_date);
      },
      error: function (error) {
        $(".fontawesome-spinners__loader").hide();
        console.log(error);
      },
    });
  };

  const changeData = (filter, formattedDate) => {
    $(".date-range-range__range").show();
    $(".date-range-status").hide();
    const responsetext = $(filter).text(formattedDate);
  };

  Drupal.behaviors.datepickers = {
    attach: function (context, settings) {
      $(".edit-created-min", context)
        .once("picker-initialized")
        .each(function (index, item) {
          const $inputMin = $(item);

          const simplepickerMin = new SimplePicker(
            ".datepicker-container-min",
            {
              disableTimeSection: true,
            }
          );

          simplepickerMin.on("submit", (date, readableDate) => {
            const formatDate = formatDateFilter(date);
            $(".edit-created-min").val(formatDate);
            $(".form-submit.exposed-submit").click();
          });

          $inputMin.click((e) => {
            simplepickerMin.open();
          });
        });

      $(".edit-created-max", context)
        .once("picker-initialized")
        .each(function (index, item) {
          const $inputMax = $(item);

          const simplepickerMax = new SimplePicker(
            ".datepicker-container-max",
            {
              disableTimeSection: true,
            }
          );

          simplepickerMax.on("submit", (date, readableDate) => {
            const formatDate = formatDateFilter(date);
            $(".edit-created-max").val(formatDate);
            $(".form-submit.exposed-submit").click();
          });

          $inputMax.click((e) => {
            simplepickerMax.open();
          });
        });
    },
  };

  Drupal.behaviors.datesSelected = {
    attach: function (context, settings) {
      $(".edit-created-min", context)
        .once("date-initialized")
        .each(function (index, item) {
          $input = $(item);

          const date = $input.val();

          if (date !== "") {
            getDrupalFormattedDate(
              date,
              ".date-range-range__range__min",
              changeData
            );
          }
        });

      $(".edit-created-max", context)
        .once("date-initialized")
        .each(function (index, item) {
          $input = $(item);

          const date = $input.val();

          if (date !== "") {
            getDrupalFormattedDate(
              date,
              ".date-range-range__range__max",
              changeData
            );
          }
        });
    },
  };

  Drupal.behaviors.datesSelected = {
    attach: function (context, settings) {
      $(".select-news-category")
        .once("select-news-initialized")
        .each(function (index, item) {
          $select = $(item);

          $select.find("li").each(function (indexOption, itemOption) {
            if (indexOption > 0) {
              let text = $(itemOption).html();
              text = text.replaceAll(" ", "-");
              text = "cat-" + text.toLowerCase();

              $(itemOption).addClass(text);
            }
          });
        });
    },
  };

  Drupal.behaviors.prettySelects = {
    attach: function (context, settings) {
      $("select", context)
        .once("select-initialized")
        .each(function (index, item) {
          $select = $(item);
          $select.niceSelect();
        });
    },
  };
})(jQuery, Drupal);
