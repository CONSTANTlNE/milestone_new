function request(cfg) {
  cfg.data = cfg.data || {};
  if (cfg.loadingEl) cfg.loadingEl.addClass('loading-mask');

  if (cfg.method && cfg.method !== 'GET') {
    cfg.headers = cfg.headers || {};
    cfg.headers['X-CSRF-TOKEN'] = _token;
  }

  $.ajax({
    type: cfg.method || 'GET',
    url: cfg.url,
    headers: cfg.headers,
    dataType: cfg.dataType,
    contentType: cfg.contentType,
    data: cfg.data,
    processData: cfg.processData,
    xhr: cfg.xhr,
    success: function (r) {
      if (cfg.loadingEl) cfg.loadingEl.removeClass('loading-mask');

      /*if (r.errorCode == 701) {
        // Open login popup
      } */

      if (typeof cfg.callback === 'function') {
        cfg.callback.call(this, r);
      }
    },
    error: function (r) {
      r = r.responseJSON || r.responseText;
      if (cfg.loadingEl) cfg.loadingEl.removeClass('loading-mask');

      if (!cfg.preventDefaultError) onError(r.message);
      cfg.onError && cfg.onError(r && r.message);
    }
  })
}

function onError(errorMessage) {
  setTimeout(function () {
    Modal.show({
      body: errorMessage || "An error occured, please try again later",
      no: "Close",
      withoutYes: true
    });
  }, 500)
}

Date.prototype.format = function (format) {
  if (isNaN(this.valueOf())) return 'Invalid Date';

  var fullMonthNames = ["January", "February", "March", "April", "May", "June",
    "July", "August", "September", "October", "November", "December"];

  var shortMonthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
    "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

  var fullDayNames = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];

  var shortDayNames = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];

  var fullYear = this.getFullYear();
  var humanYear = fullYear - 2000;

  var month = this.getMonth();
  var monthHumanRaw = month + 1;
  var monthHuman = monthHumanRaw > 9 ? monthHumanRaw : '0' + monthHumanRaw;

  var date = this.getDate();
  var humanDate = date > 9 ? date : '0' + date;

  var hour = this.getHours();
  var human24Hour = hour > 9 ? hour : '0' + hour;

  var human12Hour = hour % 12;
  if (hour === 12) human12Hour = 12;
  human12Hour = human12Hour > 9 ? human12Hour : '0' + human12Hour;

  var ampm = hour > 11 ? 'pm' : 'am';

  var minute = this.getMinutes();
  var humanMinute = minute > 9 ? minute : '0' + minute;

  var second = this.getSeconds();
  var humanSecond = second > 9 ? second : '0' + second;

  var day = this.getDay();

  var result = format
    .replace(/d/, '__d__')
    .replace(/j/, '__j__')
    .replace(/m/, '__m__')
    .replace(/n/, '__n__')
    .replace(/Y/, '__Y__')
    .replace(/y/, '__y__')
    .replace(/H/, '__H__')
    .replace(/h/, '__h__')
    .replace(/a/, '__a__')
    .replace(/A/, '__A__')
    .replace(/i/, '__i__')
    .replace(/s/, '__s__')
    .replace(/F/, '__F__')
    .replace(/M/, '__M__')
    .replace(/l/, '__l__')
    .replace(/D/, '__D__');

  return result
    .replace(/__d__/, humanDate)
    .replace(/__j__/, date)
    .replace(/__m__/, monthHuman)
    .replace(/__n__/, monthHumanRaw)
    .replace(/__Y__/, fullYear)
    .replace(/__y__/, humanYear)
    .replace(/__H__/, human24Hour)
    .replace(/__h__/, human12Hour)
    .replace(/__a__/, ampm)
    .replace(/__A__/, ampm.toUpperCase())
    .replace(/__i__/, humanMinute)
    .replace(/__s__/, humanSecond)
    .replace(/__F__/, fullMonthNames[month])
    .replace(/__M__/, shortMonthNames[month])
    .replace(/__l__/, fullDayNames[day])
    .replace(/__D__/, shortDayNames[day]);
};