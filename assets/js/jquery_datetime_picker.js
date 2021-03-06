/*
*  JQuery UI DateTimePicker v1.0.4
*  
*  Copyright (c) 2010 Daniel Harrod (http://www.projectcodegen.com/JQueryDateTimePicker.aspx)
*  Dual licensed under the MIT License (http://www.opensource.org/licenses/mit-license.php)
*  and GPL ( http://www.gnu.org/copyleft/gpl.html )
*
*  Portions of [JQuery UI Datepicker 1.8rc3] were modified on March 10, 2010. 
*  Portions of [Date Format 1.2.3] were modified on March 10, 2010.    
*  
*  http://www.projectcodegen.com/JQueryDateTimePicker.aspx
*
*  Depends:
*    jquery.ui.core.js
**/

/*
*   1.0.4 
*        In 1.0.1 changing getYear() to getFullYear() broke the absolute year determination, which is a must have.  
*        ff, chr, saf getYear returns number of years since 1900, some of the others return century+year
*        
*   1.0.3
*        Added Analog clock, minute overlay, hour overlay, minute, and hour hands.
*        New option: show24HourClock defaulted to false.
*        When show24HourClock is true, requires jquery.ui.datetimepicker.css
*   1.0.2
*        Tweaked for JQuery-UI 1.8.7 and JQuery 1.4.4 - thanks again Carl G.
*   1.0.1 
*     Correction:
*        changed getYear() to getFullYear()
*   1.0.0 Overview:
*     Additions:
*        Incude Hours / Minutes / AMPM dropdowns.
*        Absolute year determination based on absolute minimum variance to present year.
*
*     Replacements:
*        Replaced [JQuery UI Datepicker 1.8rc3] inbound parsing with a simple date check Date(inbound)
*      
*        Replaced outbound formatting with format string based on [Date Format 1.2.3]
*
*        Changed [Date Format 1.2.3] function names to play nice with [JQuery UI Datepicker 1.8rc3]   
*        
*        Minor tweaks
**/

/*
* jQuery UI Datepicker 1.8rc3
*
* Copyright (c) 2010 AUTHORS.txt (http://jqueryui.com/about)
* Dual licensed under the MIT (MIT-LICENSE.txt)
* and GPL (GPL-LICENSE.txt) licenses.
*
* http://docs.jquery.com/UI/Datepicker
*
* Depends:
*	jquery.ui.core.js
*/

/*
* Date Format 1.2.3
* (c) 2007-2009 Steven Levithan <stevenlevithan.com>
* MIT license
*
* Includes enhancements by Scott Trenda <scott.trenda.net>
* and Kris Kowal <cixar.com/~kris.kowal/>
*
* Accepts a date, a mask, or a date and a mask.
* Returns a formatted version of the given date.
* The date defaults to the current date/time.
* The mask defaults to dateFormat.masks.default.
*/

(function($) {
    $.extend($.ui, { datetimepicker: { version: "1.0.0"} }); var PROP_NAME = 'datetimepicker'; var dpuuid = new Date().getTime(); function Datetimepicker() { this.debug = false; this._curInst = null; this._keyEvent = false; this._disabledInputs = []; this._datepickerShowing = false; this._inDialog = false; this._mainDivId = 'ui-datepicker-div'; this._inlineClass = 'ui-datepicker-inline'; this._appendClass = 'ui-datepicker-append'; this._triggerClass = 'ui-datepicker-trigger'; this._dialogClass = 'ui-datepicker-dialog'; this._disableClass = 'ui-datepicker-disabled'; this._unselectableClass = 'ui-datepicker-unselectable'; this._currentClass = 'ui-datepicker-current-day'; this._dayOverClass = 'ui-datepicker-days-cell-over'; this.regional = []; this.regional[''] = { closeText: 'Close', prevText: 'Prev', nextText: 'Next', currentText: 'Now', monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'], monthNamesShort: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'], dayNames: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'], dayNamesShort: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'], dayNamesMin: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'], weekHeader: 'Wk', dateFormat: 'mm/dd/yyyy hh:MM TT', firstDay: 0, isRTL: false, showMonthAfterYear: false, yearSuffix: '' }; this._defaults = { showOn: 'focus', showAnim: 'show', showOptions: {}, defaultDate: null, appendText: '', buttonText: '...', buttonImage: '', buttonImageOnly: false, hideIfNoPrevNext: false, navigationAsDateFormat: false, gotoCurrent: false, changeMonth: false, changeYear: false, yearRange: 'c-30:c+10', showOtherMonths: false, selectOtherMonths: false, showWeek: false, calculateWeek: this.iso8601Week, shortYearCutoff: '+10', minDate: null, maxDate: null, duration: '_default', beforeShowDay: null, beforeShow: null, onSelect: null, onChangeMonthYear: null, onClose: null, numberOfMonths: 1, showCurrentAtPos: 0, stepMonths: 1, stepBigMonths: 12, altField: '', altFormat: '', constrainInput: false, showButtonPanel: false, autoSize: false, show24HourClock: false }; $.extend(this._defaults, this.regional['']); var div = '<div id="' + this._mainDivId + '" class="ui-datepicker '; div += 'ui-widget ui-widget-content ui-helper-clearfix ui-corner-all"></div>'; this.dpDiv = $(div); }
    $.extend(Datetimepicker.prototype, { markerClassName: 'hasDatetimepicker', log: function() {
        if (this.debug)
            console.log.apply('', arguments);
    }, _widgetDatepicker: function() { return this.dpDiv; }, setDefaults: function(settings) { extendRemove(this._defaults, settings || {}); return this; }, _attachDatepicker: function(target, settings) {
        var inlineSettings = null; for (var attrName in this._defaults) { var attrValue = target.getAttribute('date:' + attrName); if (attrValue) { inlineSettings = inlineSettings || {}; try { inlineSettings[attrName] = eval(attrValue); } catch (err) { inlineSettings[attrName] = attrValue; } } }
        var nodeName = target.nodeName.toLowerCase(); var inline = (nodeName == 'div' || nodeName == 'span'); if (!target.id)
            target.id = 'dp' + (++this.uuid); var inst = this._newInst($(target), inline); inst.settings = $.extend({}, settings || {}, inlineSettings || {}); if (nodeName == 'input') { this._connectDatepicker(target, inst); } else if (inline) { this._inlineDatepicker(target, inst); } 
    }, _newInst: function(target, inline) { var id = target[0].id.replace(/([^A-Za-z0-9_])/g, '\\\\$1'); return { id: id, input: target, selectedDay: 0, selectedMonth: 0, selectedYear: 0, drawMonth: 0, drawYear: 0, inline: inline, dpDiv: (!inline ? this.dpDiv : $('<div class="' + this._inlineClass + ' ui-datepicker ui-widget ui-widget-content ui-helper-clearfix ui-corner-all"></div>')) }; }, _connectDatepicker: function(target, inst) {
        var input = $(target); inst.append = $([]); inst.trigger = $([]); if (input.hasClass(this.markerClassName))
            return; this._attachments(input, inst); input.addClass(this.markerClassName).keydown(this._doKeyDown).keyup(this._doKeyUp).bind("setData.datepicker", function(event, key, value) { inst.settings[key] = value; }).bind("getData.datepicker", function(event, key) { return this._get(inst, key); }); this._autoSize(inst); $.data(target, PROP_NAME, inst);
    }, _attachments: function(input, inst) {
        var appendText = this._get(inst, 'appendText'); var isRTL = this._get(inst, 'isRTL'); if (inst.append)
            inst.append.remove(); if (appendText) { inst.append = $('<span class="' + this._appendClass + '">' + appendText + '</span>'); input[isRTL ? 'before' : 'after'](inst.append); }
        input.unbind('focus', this._showDatepicker); if (inst.trigger)
            inst.trigger.remove(); var showOn = this._get(inst, 'showOn'); if (showOn == 'focus' || showOn == 'both')
            input.focus(this._showDatepicker); if (showOn == 'button' || showOn == 'both') {
            var buttonText = this._get(inst, 'buttonText'); var buttonImage = this._get(inst, 'buttonImage'); inst.trigger = $(this._get(inst, 'buttonImageOnly') ? $('<img/>').addClass(this._triggerClass).attr({ src: buttonImage, alt: buttonText, title: buttonText }) : $('<button type="button"></button>').addClass(this._triggerClass).html(buttonImage == '' ? buttonText : $('<img/>').attr({ src: buttonImage, alt: buttonText, title: buttonText }))); input[isRTL ? 'before' : 'after'](inst.trigger); inst.trigger.click(function() {
                if ($.datetimepicker._datepickerShowing && $.datetimepicker._lastInput == input[0])
                    $.datetimepicker._hideDatepicker(); else
                    $.datetimepicker._showDatepicker(input[0]); return false;
            });
        } 
    }, _autoSize: function(inst) {
        if (this._get(inst, 'autoSize') && !inst.inline) {
            var date = new Date(2009, 12 - 1, 20); var dateFormat = this._get(inst, 'dateFormat'); if (dateFormat.match(/[DM]/)) {
                var findMax = function(names) {
                    var max = 0; var maxI = 0; for (var i = 0; i < names.length; i++) { if (names[i].length > max) { max = names[i].length; maxI = i; } }
                    return maxI;
                }; date.setMonth(findMax(this._get(inst, (dateFormat.match(/MM/) ? 'monthNames' : 'monthNamesShort')))); date.setDate(findMax(this._get(inst, (dateFormat.match(/DD/) ? 'dayNames' : 'dayNamesShort'))) + 20 - date.getDay());
            }
            inst.input.attr('size', this._formatDate(inst, date).length);
        } 
    }, _inlineDatepicker: function(target, inst) {
        var divSpan = $(target); if (divSpan.hasClass(this.markerClassName))
            return; divSpan.addClass(this.markerClassName).append(inst.dpDiv).bind("setData.datepicker", function(event, key, value) { inst.settings[key] = value; }).bind("getData.datepicker", function(event, key) { return this._get(inst, key); }); $.data(target, PROP_NAME, inst); this._setDate(inst, this._getDefaultDate(inst), true); this._updateDatepicker(inst); this._updateAlternate(inst);
    }, _dialogDatepicker: function(input, date, onSelect, settings, pos) {
        var inst = this._dialogInst; if (!inst) { var id = 'dp' + (++this.uuid); this._dialogInput = $('<input type="text" id="' + id + '" style="position: absolute; top: -100px; width: 0px; z-index: -10;"/>'); this._dialogInput.keydown(this._doKeyDown); $('body').append(this._dialogInput); inst = this._dialogInst = this._newInst(this._dialogInput, false); inst.settings = {}; $.data(this._dialogInput[0], PROP_NAME, inst); }
        extendRemove(inst.settings, settings || {}); date = (date && date.constructor == Date ? this._formatDate(inst, date) : date); this._dialogInput.val(date); this._pos = (pos ? (pos.length ? pos : [pos.pageX, pos.pageY]) : null); if (!this._pos) { var browserWidth = document.documentElement.clientWidth; var browserHeight = document.documentElement.clientHeight; var scrollX = document.documentElement.scrollLeft || document.body.scrollLeft; var scrollY = document.documentElement.scrollTop || document.body.scrollTop; this._pos = [(browserWidth / 2) - 100 + scrollX, (browserHeight / 2) - 150 + scrollY]; }
        this._dialogInput.css('left', (this._pos[0] + 20) + 'px').css('top', this._pos[1] + 'px'); inst.settings.onSelect = onSelect; this._inDialog = true; this.dpDiv.addClass(this._dialogClass); this._showDatepicker(this._dialogInput[0]); if ($.blockUI)
            $.blockUI(this.dpDiv); $.data(this._dialogInput[0], PROP_NAME, inst); return this;
    }, _destroyDatepicker: function(target) {
        var $target = $(target); var inst = $.data(target, PROP_NAME); if (!$target.hasClass(this.markerClassName)) { return; }
        var nodeName = target.nodeName.toLowerCase(); $.removeData(target, PROP_NAME); if (nodeName == 'input') { inst.append.remove(); inst.trigger.remove(); $target.removeClass(this.markerClassName).unbind('focus', this._showDatepicker).unbind('keydown', this._doKeyDown).unbind('keyup', this._doKeyUp); } else if (nodeName == 'div' || nodeName == 'span')
            $target.removeClass(this.markerClassName).empty();
    }, _enableDatepicker: function(target) {
        var $target = $(target); var inst = $.data(target, PROP_NAME); if (!$target.hasClass(this.markerClassName)) { return; }
        var nodeName = target.nodeName.toLowerCase(); if (nodeName == 'input') { target.disabled = false; inst.trigger.filter('button').each(function() { this.disabled = false; }).end().filter('img').css({ opacity: '1.0', cursor: '' }); }
        else if (nodeName == 'div' || nodeName == 'span') { var inline = $target.children('.' + this._inlineClass); inline.children().removeClass('ui-state-disabled'); }
        this._disabledInputs = $.map(this._disabledInputs, function(value) { return (value == target ? null : value); });
    }, _disableDatepicker: function(target) {
        var $target = $(target); var inst = $.data(target, PROP_NAME); if (!$target.hasClass(this.markerClassName)) { return; }
        var nodeName = target.nodeName.toLowerCase(); if (nodeName == 'input') { target.disabled = true; inst.trigger.filter('button').each(function() { this.disabled = true; }).end().filter('img').css({ opacity: '0.5', cursor: 'default' }); }
        else if (nodeName == 'div' || nodeName == 'span') { var inline = $target.children('.' + this._inlineClass); inline.children().addClass('ui-state-disabled'); }
        this._disabledInputs = $.map(this._disabledInputs, function(value) { return (value == target ? null : value); }); this._disabledInputs[this._disabledInputs.length] = target;
    }, _isDisabledDatepicker: function(target) {
        if (!target) { return false; }
        for (var i = 0; i < this._disabledInputs.length; i++) {
            if (this._disabledInputs[i] == target)
                return true;
        }
        return false;
    }, _getInst: function(target) {
        try { return $.data(target, PROP_NAME); }
        catch (err) { throw 'Missing instance data for this datepicker'; } 
    }, _optionDatepicker: function(target, name, value) {
        var inst = this._getInst(target); if (arguments.length == 2 && typeof name == 'string') { return (name == 'defaults' ? $.extend({}, $.datetimepicker._defaults) : (inst ? (name == 'all' ? $.extend({}, inst.settings) : this._get(inst, name)) : null)); }
        var settings = name || {}; if (typeof name == 'string') { settings = {}; settings[name] = value; }
        if (inst) {
            if (this._curInst == inst) { this._hideDatepicker(); }
            var date = this._getDateDatepicker(target, true); extendRemove(inst.settings, settings); this._attachments($(target), inst); this._autoSize(inst); this._setDateDatepicker(target, date); this._updateDatepicker(inst);
        } 
    }, _changeDatepicker: function(target, name, value) { this._optionDatepicker(target, name, value); }, _refreshDatepicker: function(target) { var inst = this._getInst(target); if (inst) { this._updateDatepicker(inst); } }, _setDateDatepicker: function(target, date) { var inst = this._getInst(target); if (inst) { this._setDate(inst, date); this._updateDatepicker(inst); this._updateAlternate(inst); } }, _getDateDatepicker: function(target, noDefault) {
        var inst = this._getInst(target); if (inst && !inst.inline)
            this._setDateFromField(inst, noDefault); return (inst ? this._getDate(inst) : null);
    }, _doKeyDown: function(event) {
        var inst = $.datetimepicker._getInst(event.target); var handled = true; var isRTL = inst.dpDiv.is('.ui-datepicker-rtl'); inst._keyEvent = true; if ($.datetimepicker._datepickerShowing)
            switch (event.keyCode) {
            case 9: $.datetimepicker._hideDatepicker(); handled = false; break; case 13: var sel = $('td.' + $.datetimepicker._dayOverClass, inst.dpDiv).add($('td.' + $.datetimepicker._currentClass, inst.dpDiv)); if (sel[0])
                    $.datetimepicker._selectDay(event.target, inst.selectedMonth, inst.selectedYear, sel[0], inst.currentHour, inst.currentMinute, inst.currentAMPM); else
                    $.datetimepicker._hideDatepicker(); return false; break; case 27: $.datetimepicker._hideDatepicker(); break; case 33: $.datetimepicker._adjustDate(event.target, (event.ctrlKey ? -$.datetimepicker._get(inst, 'stepBigMonths') : -$.datetimepicker._get(inst, 'stepMonths')), 'M'); break; case 34: $.datetimepicker._adjustDate(event.target, (event.ctrlKey ? +$.datetimepicker._get(inst, 'stepBigMonths') : +$.datetimepicker._get(inst, 'stepMonths')), 'M'); break; case 35: if (event.ctrlKey || event.metaKey) $.datetimepicker._clearDate(event.target); handled = event.ctrlKey || event.metaKey; break; case 36: if (event.ctrlKey || event.metaKey) $.datetimepicker._gotoToday(event.target); handled = event.ctrlKey || event.metaKey; break; case 37: if (event.ctrlKey || event.metaKey) $.datetimepicker._adjustDate(event.target, (isRTL ? +1 : -1), 'D'); handled = event.ctrlKey || event.metaKey; if (event.originalEvent.altKey) $.datetimepicker._adjustDate(event.target, (event.ctrlKey ? -$.datetimepicker._get(inst, 'stepBigMonths') : -$.datetimepicker._get(inst, 'stepMonths')), 'M'); break; case 38: if (event.ctrlKey || event.metaKey) $.datetimepicker._adjustDate(event.target, -7, 'D'); handled = event.ctrlKey || event.metaKey; break; case 39: if (event.ctrlKey || event.metaKey) $.datetimepicker._adjustDate(event.target, (isRTL ? -1 : +1), 'D'); handled = event.ctrlKey || event.metaKey; if (event.originalEvent.altKey) $.datetimepicker._adjustDate(event.target, (event.ctrlKey ? +$.datetimepicker._get(inst, 'stepBigMonths') : +$.datetimepicker._get(inst, 'stepMonths')), 'M'); break; case 40: if (event.ctrlKey || event.metaKey) $.datetimepicker._adjustDate(event.target, +7, 'D'); handled = event.ctrlKey || event.metaKey; break; default: handled = false;
        }
        else if (event.keyCode == 36 && event.ctrlKey)
            $.datetimepicker._showDatepicker(this); else { handled = false; }
        if (handled) { event.preventDefault(); event.stopPropagation(); } 
    }, _Left: function(str, name) {
        if (n <= 0)
            return ""; else if (n > String(str).length)
            return str; else
            return String(str).substring(0, n);
    }, _DetermineYear: function(year) {
        var yearLength = String(year).length; var CurrentDate = new Date(); var PresentYear = CurrentDate.getFullYear(); switch (yearLength) {
            case 0: alert(CurrentDate.getFullYear()); return CurrentDate.getFullYear(); break; case 1: return '200' + year; break; case 2: var FutureYear = parseInt('20' + year); var PastYear = parseInt('19' + year); var FutureDiff = Math.abs(FutureYear - PresentYear); var PastDiff = Math.abs(PastYear - PresentYear); if (PastDiff < FutureDiff) { return PastYear; } else { return FutureYear; }
            case 3: var FutureYear = parseInt('20' + $.datetimepicker._Right(year, 2)); var PastYear = parseInt('19' + $.datetimepicker._Right(year, 2)); var FutureDiff = Math.abs(FutureYear - PresentYear); var PastDiff = Math.abs(PastYear - PresentYear); if (PastDiff < FutureDiff) { return PastYear; } else { return FutureYear; }
                break; case 4: return year; default: return _Left(year, 4);
        } 
    }, _doKeyUp: function(event) {
        var inst = $.datetimepicker._getInst(event.target); if (inst.input.val() != inst.lastVal) {
            try { var date = new Date(inst.input.val()); if (date != "NaN") { date.setYear($.datetimepicker._DetermineYear(date.getYear())); if (date) { $.datetimepicker._setDateFromField(inst); $.datetimepicker._updateAlternate(inst); $.datetimepicker._updateDatepicker(inst); } } }
            catch (event) { $.datetimepicker.log(event); } 
        }
        return true;
    }, _showDatepicker: function(input) {
        input = input.target || input; if (input.nodeName.toLowerCase() != 'input')
            input = $('input', input.parentNode)[0]; if ($.datetimepicker._isDisabledDatepicker(input) || $.datetimepicker._lastInput == input)
            return; var inst = $.datetimepicker._getInst(input); if ($.datetimepicker._curInst && $.datetimepicker._curInst != inst) { $.datetimepicker._curInst.dpDiv.stop(true, true); }
        var beforeShow = $.datetimepicker._get(inst, 'beforeShow'); extendRemove(inst.settings, (beforeShow ? beforeShow.apply(input, [input, inst]) : {})); inst.lastVal = null; $.datetimepicker._lastInput = input; $.datetimepicker._setDateFromField(inst); if ($.datetimepicker._inDialog)
            input.value = ''; if (!$.datetimepicker._pos) { $.datetimepicker._pos = $.datetimepicker._findPos(input); $.datetimepicker._pos[1] += input.offsetHeight; }
        var isFixed = false; $(input).parents().each(function() { isFixed |= $(this).css('position') == 'fixed'; return !isFixed; }); if (isFixed && $.browser.opera) { $.datetimepicker._pos[0] -= document.documentElement.scrollLeft; $.datetimepicker._pos[1] -= document.documentElement.scrollTop; }
        var offset = { left: $.datetimepicker._pos[0], top: $.datetimepicker._pos[1] }; $.datetimepicker._pos = null; inst.dpDiv.css({ position: 'absolute', display: 'block', top: '-1000px' }); $.datetimepicker._updateDatepicker(inst); offset = $.datetimepicker._checkOffset(inst, offset, isFixed); inst.dpDiv.css({ position: ($.datetimepicker._inDialog && $.blockUI ? 'static' : (isFixed ? 'fixed' : 'absolute')), display: 'none', left: offset.left + 'px', top: offset.top + 'px' }); if (!inst.inline) {
            var showAnim = $.datetimepicker._get(inst, 'showAnim'); var duration = $.datetimepicker._get(inst, 'duration'); var postProcess = function() { $.datetimepicker._datepickerShowing = true; var borders = $.datetimepicker._getBorders(inst.dpDiv); inst.dpDiv.find('iframe.ui-datepicker-cover').css({ left: -borders[0], top: -borders[1], width: inst.dpDiv.outerWidth(), height: inst.dpDiv.outerHeight() }); }; inst.dpDiv.zIndex($(input).zIndex() + 1); if ($.effects && $.effects[showAnim])
                inst.dpDiv.show(showAnim, $.datetimepicker._get(inst, 'showOptions'), duration, postProcess); else
                inst.dpDiv[showAnim || 'show']((showAnim ? duration : null), postProcess); if (!showAnim)
                postProcess(); if (inst.input.is(':visible') && !inst.input.is(':disabled'))
                inst.input.focus(); $.datetimepicker._curInst = inst;
        } 
    }, _updateDatepicker: function(inst) {
        var self = this; var borders = $.datetimepicker._getBorders(inst.dpDiv); inst.dpDiv.empty().append(this._generateHTML(inst)).find('iframe.ui-datepicker-cover').css({ left: -borders[0], top: -borders[1], width: inst.dpDiv.outerWidth(), height: inst.dpDiv.outerHeight() }).end().find('button, .ui-datepicker-prev, .ui-datepicker-next, .ui-datepicker-calendar td a').bind('mouseout', function() { $(this).removeClass('ui-state-hover'); if (this.className.indexOf('ui-datepicker-prev') != -1) $(this).removeClass('ui-datepicker-prev-hover'); if (this.className.indexOf('ui-datepicker-next') != -1) $(this).removeClass('ui-datepicker-next-hover'); }).bind('mouseover', function() { if (!self._isDisabledDatepicker(inst.inline ? inst.dpDiv.parent()[0] : inst.input[0])) { $(this).parents('.ui-datepicker-calendar').find('a').removeClass('ui-state-hover'); $(this).addClass('ui-state-hover'); if (this.className.indexOf('ui-datepicker-prev') != -1) $(this).addClass('ui-datepicker-prev-hover'); if (this.className.indexOf('ui-datepicker-next') != -1) $(this).addClass('ui-datepicker-next-hover'); } }).end().find('.' + this._dayOverClass + ' a').trigger('mouseover').end(); var numMonths = this._getNumberOfMonths(inst); var cols = numMonths[1]; var width = 17; if (cols > 1)
            inst.dpDiv.addClass('ui-datepicker-multi-' + cols).css('width', (width * cols) + 'em'); else
            inst.dpDiv.removeClass('ui-datepicker-multi-2 ui-datepicker-multi-3 ui-datepicker-multi-4').width(''); inst.dpDiv[(numMonths[0] != 1 || numMonths[1] != 1 ? 'add' : 'remove') + 'Class']('ui-datepicker-multi'); inst.dpDiv[(this._get(inst, 'isRTL') ? 'add' : 'remove') + 'Class']('ui-datepicker-rtl'); var show24HourClock = this._get(inst, 'show24HourClock'); if (inst.currentHour != undefined) {
            $("#DP_jQuery_Hour_" + dpuuid).val(inst.currentHour); $("#DP_jQuery_Minute_" + dpuuid).val(inst.currentMinute); $("#DP_jQuery_AMPM_" + dpuuid).val(inst.currentAMPM); var Hour = inst.currentHour; if (inst.currentAMPM == 'PM') { Hour = parseInt(Hour) + 12; }
            if (show24HourClock) { $.datetimepicker.DrawHours($("#DP_jQuery_clock_" + dpuuid)[0], Hour); $.datetimepicker.DrawMinutes($("#DP_jQuery_clock_" + dpuuid)[0], inst.currentMinute); } 
        }
        if (inst == $.datetimepicker._curInst && $.datetimepicker._datepickerShowing && inst.input && inst.input.is(':visible') && !inst.input.is(':disabled'))
            inst.input.focus(); if (show24HourClock) {
            $("#DP_jQuery_Hour_" + dpuuid).change(function(e) {
                var objID = this.id.split("_"); var ID = objID[objID.length - 1]; var Hour = $("#DP_jQuery_Hour_" + ID).val(); var AMPM = $("#DP_jQuery_AMPM_" + ID).val(); if (AMPM == 'PM')
                    Hour = parseInt(Hour) + 12; $.datetimepicker.DrawHours($("#DP_jQuery_clock_" + ID)[0], Hour);
            }); $("#DP_jQuery_AMPM_" + dpuuid).change(function(e) {
                var objID = this.id.split("_"); var ID = objID[objID.length - 1]; var Hour = $("#DP_jQuery_Hour_" + ID).val(); var AMPM = $("#DP_jQuery_AMPM_" + ID).val(); if (AMPM == 'PM')
                    Hour = parseInt(Hour) + 12; $.datetimepicker.DrawHours($("#DP_jQuery_clock_" + ID)[0], Hour);
            }); $("#DP_jQuery_Minute_" + dpuuid).change(function(e) { var objID = this.id.split("_"); var ID = objID[objID.length - 1]; $.datetimepicker.DrawMinutes($("#DP_jQuery_clock_" + ID)[0], $("#DP_jQuery_Minute_" + dpuuid).val()); }); $("#DP_jQuery_clock_" + dpuuid).mousemove(function(e) {
                var Pos = $.datetimepicker._findPos(this); var xOriginal = e.pageX - Pos[0] - 196; var yOriginal = e.pageY - Pos[1] - 196; var x = Math.abs(xOriginal); var y = Math.abs(yOriginal); var Distance = Math.sqrt((x * x) + (y * y))
                if (Distance > 129 && Distance < 196) { this.children[2].style.display = ''; } else { this.children[2].style.display = 'none'; }
                if (Distance <= 129 && Distance > 50) { this.children[3].style.display = ''; } else { this.children[3].style.display = 'none'; } 
            }); $("#DP_jQuery_clock_" + dpuuid).click(function(e) {
                var Pos = $.datetimepicker._findPos(this); var xOriginal = e.pageX - Pos[0] - 196; var yOriginal = e.pageY - Pos[1] - 196; var core = 0; if (xOriginal > 0 && yOriginal < 0) { core = 1; }
                if (xOriginal < 0 && yOriginal < 0) { core = 2; }
                if (xOriginal < 0 && yOriginal > 0) { core = 3; }
                if (xOriginal > 0 && yOriginal > 0) { core = 4; }
                var x = Math.abs(xOriginal); var y = Math.abs(yOriginal); var Distance = Math.sqrt((x * x) + (y * y))
                var InMinuteRange = false; if (Distance > 127 && Distance < 196) { InMinuteRange = true; }
                var InHourRange = false; if (Distance <= 129 && Distance > 50) { InHourRange = true; }
                var v; var Minute; k = y / Distance; if (core == 1) {
                    if (k > 0.987)
                        v = '12'; if (k <= 0.987 && k > 0.922)
                        v = '13'; if (k <= 0.922 && k > 0.785)
                        v = '14'; if (k <= 0.785 && k > 0.600)
                        v = '15'; if (k <= 0.600 && k > 0.374)
                        v = '16'; if (k <= 0.374 && k > 0.152)
                        v = '17'; if (k <= 0.152)
                        v = '18'; if (k > 0.998)
                        Minute = '00'; if (k <= 0.998 && k > 0.986)
                        Minute = '01'; if (k <= 0.986 && k > 0.955)
                        Minute = '02'; if (k <= 0.955 && k > 0.930)
                        Minute = '03'; if (k <= 0.930 && k > 0.893)
                        Minute = '04'; if (k <= 0.893 && k > 0.837)
                        Minute = '05'; if (k <= 0.837 && k > 0.774)
                        Minute = '06'; if (k <= 0.774 && k > 0.689)
                        Minute = '07'; if (k <= 0.689 && k > 0.621)
                        Minute = '08'; if (k <= 0.621 && k > 0.558)
                        Minute = '09'; if (k <= 0.558 && k > 0.472)
                        Minute = '10'
                    if (k <= 0.472 && k > 0.356)
                        Minute = '11'
                    if (k <= 0.356 && k > 0.228)
                        Minute = '12'
                    if (k <= 0.228 && k > 0.173)
                        Minute = '13'
                    if (k <= 0.173 && k > 0.082)
                        Minute = '14'
                    if (k <= 0.082)
                        Minute = '15'
                }
                if (core == 2) {
                    if (k > 0.987)
                        v = '12'; if (k <= 0.987 && k > 0.922)
                        v = '11'; if (k <= 0.922 && k > 0.785)
                        v = '10'; if (k <= 0.785 && k > 0.600)
                        v = '09'; if (k <= 0.600 && k > 0.374)
                        v = '08'; if (k <= 0.374 && k > 0.152)
                        v = '07'; if (k <= 0.152)
                        v = '06'; if (k > 0.998)
                        Minute = '00'; if (k <= 0.998 && k > 0.986)
                        Minute = '59'; if (k <= 0.986 && k > 0.955)
                        Minute = '58'; if (k <= 0.955 && k > 0.930)
                        Minute = '57'; if (k <= 0.930 && k > 0.893)
                        Minute = '56'; if (k <= 0.893 && k > 0.837)
                        Minute = '55'; if (k <= 0.837 && k > 0.774)
                        Minute = '54'; if (k <= 0.774 && k > 0.689)
                        Minute = '53'; if (k <= 0.689 && k > 0.621)
                        Minute = '52'; if (k <= 0.621 && k > 0.558)
                        Minute = '51'; if (k <= 0.558 && k > 0.472)
                        Minute = '50'
                    if (k <= 0.472 && k > 0.356)
                        Minute = '49'
                    if (k <= 0.356 && k > 0.228)
                        Minute = '48'
                    if (k <= 0.228 && k > 0.173)
                        Minute = '47'
                    if (k <= 0.173 && k > 0.082)
                        Minute = '46'
                    if (k <= 0.082)
                        Minute = '45'
                }
                if (core == 3) {
                    if (k > 0.987)
                        v = '00'; if (k <= 0.987 && k > 0.922)
                        v = '01'; if (k <= 0.922 && k > 0.785)
                        v = '02'; if (k <= 0.785 && k > 0.600)
                        v = '03'; if (k <= 0.600 && k > 0.374)
                        v = '04'; if (k <= 0.374 && k > 0.152)
                        v = '05'; if (k <= 0.152)
                        v = '06'; if (k > 0.998)
                        Minute = '30'; if (k <= 0.998 && k > 0.986)
                        Minute = '31'; if (k <= 0.986 && k > 0.955)
                        Minute = '32'; if (k <= 0.955 && k > 0.930)
                        Minute = '33'; if (k <= 0.930 && k > 0.893)
                        Minute = '34'; if (k <= 0.893 && k > 0.837)
                        Minute = '35'; if (k <= 0.837 && k > 0.774)
                        Minute = '36'; if (k <= 0.774 && k > 0.689)
                        Minute = '37'; if (k <= 0.689 && k > 0.621)
                        Minute = '38'; if (k <= 0.621 && k > 0.558)
                        Minute = '39'; if (k <= 0.558 && k > 0.472)
                        Minute = '40'
                    if (k <= 0.472 && k > 0.356)
                        Minute = '41'
                    if (k <= 0.356 && k > 0.228)
                        Minute = '42'
                    if (k <= 0.228 && k > 0.173)
                        Minute = '43'
                    if (k <= 0.173 && k > 0.082)
                        Minute = '44'
                    if (k <= 0.082)
                        Minute = '45'
                }
                if (core == 4) {
                    if (k > 0.987)
                        v = '00'; if (k <= 0.987 && k > 0.922)
                        v = '23'; if (k <= 0.922 && k > 0.785)
                        v = '22'; if (k <= 0.785 && k > 0.600)
                        v = '21'; if (k <= 0.600 && k > 0.374)
                        v = '20'; if (k <= 0.374 && k > 0.152)
                        v = '19'; if (k <= 0.152)
                        v = '18'; if (k > 0.998)
                        Minute = '30'; if (k <= 0.998 && k > 0.986)
                        Minute = '29'; if (k <= 0.986 && k > 0.955)
                        Minute = '28'; if (k <= 0.955 && k > 0.930)
                        Minute = '27'; if (k <= 0.930 && k > 0.893)
                        Minute = '26'; if (k <= 0.893 && k > 0.837)
                        Minute = '25'; if (k <= 0.837 && k > 0.774)
                        Minute = '24'; if (k <= 0.774 && k > 0.689)
                        Minute = '23'; if (k <= 0.689 && k > 0.621)
                        Minute = '22'; if (k <= 0.621 && k > 0.558)
                        Minute = '21'; if (k <= 0.558 && k > 0.472)
                        Minute = '20'
                    if (k <= 0.472 && k > 0.356)
                        Minute = '19'
                    if (k <= 0.356 && k > 0.228)
                        Minute = '18'
                    if (k <= 0.228 && k > 0.173)
                        Minute = '17'
                    if (k <= 0.173 && k > 0.082)
                        Minute = '16'
                    if (k <= 0.082)
                        Minute = '15'
                }
                if (core == 0) {
                    if (k == 1) { Minute = '15'; }
                    if (k == 0) { Minute = '45'; }
                    if (xOriginal < 0) { v = '06'; Minute = '45'; } else { v = '18'; Minute = '15'; }
                    if (xOriginal == 0 && yOriginal == 0) { v = '12'; Minute = '00'; }
                    if (yOriginal > 0 && xOriginal == 0) { v = '00'; Minute = '30'; }
                    if (xOriginal == 0 && yOriginal < 0) { Minute = '00'; v = '12'; } 
                }
                if (InMinuteRange) { $.datetimepicker.DrawMinutes(this, Minute); }
                if (InHourRange) { $.datetimepicker.DrawHours(this, v); } 
            });
        } 
    }, DrawHours: function(t, v) {
        var objID = t.id.split("_"); var ID = objID[objID.length - 1]; if (parseInt(v) > 12) { $("#DP_jQuery_Hour_" + ID).val(parseInt(v) - 12); $("#DP_jQuery_AMPM_" + ID).val("PM"); }
        else {
            if (v == '00') { $("#DP_jQuery_Hour_" + ID).val(parseInt('12')); } else {
                $("#DP_jQuery_Hour_" + ID).val(parseInt(v).toString()); if (v == '08') { $("#DP_jQuery_Hour_" + ID).val("8"); }
                if (v == '09') { $("#DP_jQuery_Hour_" + ID).val("9"); } 
            }
            $("#DP_jQuery_AMPM_" + ID).val("AM");
        }
        if (v == '00')
            $("#DP_jQuery_AMPM_" + ID).val("AM"); if (v == '12')
            $("#DP_jQuery_AMPM_" + ID).val("PM"); var HourIndex = v; if (HourIndex != '12')
            HourIndex = HourIndex; if (HourIndex > 11)
            HourIndex = HourIndex - 12; if (v == 0)
            HourIndex = 12; if (v == 12)
            HourIndex = 0; if (v > 11 || v == 0) {
            var IndexLocation = ((HourIndex * 269))
            t.children[1].style.backgroundPosition = '0px -' + IndexLocation + 'px';
        } else {
            HourIndex = Math.abs(12 - HourIndex); var IndexLocation = ((HourIndex * 269))
            t.children[1].style.backgroundPosition = '-269px -' + IndexLocation + 'px';
        } 
    }, DrawMinutes: function(t, Minute) {
        var objID = t.id.split("_"); var ID = objID[objID.length - 1]; var Minutes = parseInt(Minute).toString(); $("#DP_jQuery_Minute_" + ID).val(parseInt(Minute).toString()); if (Minute == '08')
            $("#DP_jQuery_Minute_" + ID).val('8'); if (Minute == '09')
            $("#DP_jQuery_Minute_" + ID).val('9'); var ImageIndex = Minute
        if (ImageIndex > 30) { ImageIndex = ImageIndex - 60; ImageIndex = Math.abs(ImageIndex); t.children[0].style.backgroundPosition = '-269px -' + (ImageIndex * 269) + 'px'; } else { t.children[0].style.backgroundPosition = '0px -' + (ImageIndex * 269) + 'px'; } 
    }, _getBorders: function(elem) { var convert = function(value) { return { thin: 1, medium: 2, thick: 3}[value] || value; }; return [parseFloat(convert(elem.css('border-left-width'))), parseFloat(convert(elem.css('border-top-width')))]; }, _checkOffset: function(inst, offset, isFixed) { var dpWidth = inst.dpDiv.outerWidth(); var dpHeight = inst.dpDiv.outerHeight(); var inputWidth = inst.input ? inst.input.outerWidth() : 0; var inputHeight = inst.input ? inst.input.outerHeight() : 0; var viewWidth = document.documentElement.clientWidth + $(document).scrollLeft(); var viewHeight = document.documentElement.clientHeight + $(document).scrollTop(); offset.left -= (this._get(inst, 'isRTL') ? (dpWidth - inputWidth) : 0); offset.left -= (isFixed && offset.left == inst.input.offset().left) ? $(document).scrollLeft() : 0; offset.top -= (isFixed && offset.top == (inst.input.offset().top + inputHeight)) ? $(document).scrollTop() : 0; offset.left -= Math.min(offset.left, (offset.left + dpWidth > viewWidth && viewWidth > dpWidth) ? Math.abs(offset.left + dpWidth - viewWidth) : 0); offset.top -= Math.min(offset.top, (offset.top + dpHeight > viewHeight && viewHeight > dpHeight) ? Math.abs(dpHeight + inputHeight) : 0); return offset; }, _hideDatepicker: function(input) {
        var inst = this._curInst; if (!inst || (input && inst != $.data(input, PROP_NAME)))
            return; if (this._datepickerShowing) {
            var showAnim = this._get(inst, 'showAnim'); var duration = this._get(inst, 'duration'); var postProcess = function() { $.datetimepicker._tidyDialog(inst); this._curInst = null; }; if ($.effects && $.effects[showAnim])
                inst.dpDiv.hide(showAnim, $.datetimepicker._get(inst, 'showOptions'), duration, postProcess); else
                inst.dpDiv[(showAnim == 'slideDown' ? 'slideUp' : (showAnim == 'fadeIn' ? 'fadeOut' : 'hide'))]((showAnim ? duration : null), postProcess); if (!showAnim)
                postProcess(); var onClose = this._get(inst, 'onClose'); if (onClose)
                onClose.apply((inst.input ? inst.input[0] : null), [(inst.input ? inst.input.val() : ''), inst]); this._datepickerShowing = false; this._lastInput = null; if (this._inDialog) { this._dialogInput.css({ position: 'absolute', left: '0', top: '-100px' }); if ($.blockUI) { $.unblockUI(); $('body').append(this.dpDiv); } }
            this._inDialog = false;
        } 
    }, _tidyDialog: function(inst) { inst.dpDiv.removeClass(this._dialogClass).unbind('.ui-datepicker-calendar'); }, _checkExternalClick: function(event) {
        if (!$.datetimepicker._curInst)
            return; var $target = $(event.target); if ($target[0].id != $.datetimepicker._mainDivId && $target.parents('#' + $.datetimepicker._mainDivId).length == 0 && !$target.hasClass($.datetimepicker.markerClassName) && !$target.hasClass($.datetimepicker._triggerClass) && $.datetimepicker._datepickerShowing && !($.datetimepicker._inDialog && $.blockUI))
            $.datetimepicker._hideDatepicker();
    }, _adjustDate: function(id, offset, period) {
        var target = $(id); var inst = this._getInst(target[0]); if (this._isDisabledDatepicker(target[0])) { return; }
        this._adjustInstDate(inst, offset +
(period == 'M' ? this._get(inst, 'showCurrentAtPos') : 0), period); this._updateDatepicker(inst);
    }, _gotoToday: function(id) {
        var target = $(id); var inst = this._getInst(target[0]); if (this._get(inst, 'gotoCurrent') && inst.currentDay) { inst.selectedDay = inst.currentDay; inst.drawMonth = inst.selectedMonth = inst.currentMonth; inst.drawYear = inst.selectedYear = inst.currentYear; inst.selectedHour = inst.currentHour; inst.selectedMinute = inst.currentMinute; inst.selectedAMPM = inst.currentAMPM; }
        else {
            var date = new Date(); inst.selectedDay = date.getDate(); inst.drawMonth = inst.selectedMonth = date.getMonth(); inst.drawYear = inst.selectedYear = date.getFullYear(); if (date.getHours() > 12) { inst.selectedHour = date.getHours() - 12; inst.selectedAMPM = "PM"; }
            else { inst.selectedHour = date.getHours(); inst.selectedAMPM = "AM"; }
            if (date.getHours() == 12) { inst.selectedAMPM = "PM"; }
            if (date.getHours() == 00) { inst.selectedHour = 12; }
            inst.selectedMinute = date.getMinutes();
        }
        this._notifyChange(inst); this._adjustDate(target);
    }, _selectMonthYear: function(id, select, period) { var target = $(id); var inst = this._getInst(target[0]); inst._selectingMonthYear = false; inst['selected' + (period == 'M' ? 'Month' : 'Year')] = inst['draw' + (period == 'M' ? 'Month' : 'Year')] = parseInt(select.options[select.selectedIndex].value, 10); this._notifyChange(inst); this._adjustDate(target); }, _clickMonthYear: function(id) {
        var target = $(id); var inst = this._getInst(target[0]); if (inst.input && inst._selectingMonthYear && !$.browser.msie)
            inst.input.focus(); inst._selectingMonthYear = !inst._selectingMonthYear;
    }, _selectDay: function(id, month, year, td, hh, mm, am) {
        var target = $(id); if ($(td).hasClass(this._unselectableClass) || this._isDisabledDatepicker(target[0])) { return; }
        var inst = this._getInst(target[0]); inst.selectedDay = inst.currentDay = $('a', td).html(); inst.selectedMonth = inst.currentMonth = month; inst.selectedYear = inst.currentYear = year; inst.selectedHour = inst.currentHour = $("#DP_jQuery_Hour_" + dpuuid).val()
        inst.selectedMinute = inst.currentMinute = $("#DP_jQuery_Minute_" + dpuuid).val(); inst.selectedAMPM = inst.currentAMPM = $("#DP_jQuery_AMPM_" + dpuuid).val(); this._selectDate(id, this._formatDate(inst, inst.currentDay, inst.currentMonth, inst.currentYear));
    }, _clearDate: function(id) { var target = $(id); var inst = this._getInst(target[0]); this._selectDate(target, ''); }, _selectDate: function(id, dateStr) {
        var target = $(id); var inst = this._getInst(target[0]); dateStr = (dateStr != null ? dateStr : this._formatDate(inst)); if (inst.input)
            inst.input.val(dateStr); this._updateAlternate(inst); var onSelect = this._get(inst, 'onSelect'); if (onSelect)
            onSelect.apply((inst.input ? inst.input[0] : null), [dateStr, inst]); else if (inst.input)
            inst.input.trigger('change'); if (inst.inline)
            this._updateDatepicker(inst); else {
            this._hideDatepicker(); this._lastInput = inst.input[0]; if (typeof (inst.input[0]) != 'object')
                inst.input.focus(); this._lastInput = null;
        } 
    }, _updateAlternate: function(inst) { var altField = this._get(inst, 'altField'); if (altField) { var altFormat = this._get(inst, 'altFormat') || this._get(inst, 'dateFormat'); var date = this._getDate(inst); var dateStr = this.formatDate(altFormat, date, this._getFormatConfig(inst)); $(altField).each(function() { $(this).val(dateStr); }); } }, noWeekends: function(date) { var day = date.getDay(); return [(day > 0 && day < 6), '']; }, iso8601Week: function(date) { var checkDate = new Date(date.getTime()); checkDate.setDate(checkDate.getDate() + 4 - (checkDate.getDay() || 7)); var time = checkDate.getTime(); checkDate.setMonth(0); checkDate.setDate(1); return Math.floor(Math.round((time - checkDate) / 86400000) / 7) + 1; }, parseDate: function(format, value, settings) {
        if (format == null || value == null)
            throw 'Invalid arguments'; value = (typeof value == 'object' ? value.toString() : value + ''); if (value == '')
            return null; var dte = new Date(value); dte.setYear(this._DetermineYear(dte.getYear())); if (dte == "NaN") { return null; } else { return dte; }
        return null;
    }, formatDate: function(format, date, settings) {
        if (!date)
            return ''; return date.format(format);
    }, _possibleChars: function(format) {
        var chars = ''; var literal = false; var lookAhead = function(match) {
            var matches = (iFormat + 1 < format.length && format.charAt(iFormat + 1) == match); if (matches)
                iFormat++; return matches;
        }; for (var iFormat = 0; iFormat < format.length; iFormat++)
            if (literal)
            if (format.charAt(iFormat) == "'" && !lookAhead("'"))
            literal = false; else
            chars += format.charAt(iFormat); else
            switch (format.charAt(iFormat)) {
            case 'd': case 'm': case 'y': case '@': chars += '0123456789'; break; case 'D': case 'M': return null; case "'": if (lookAhead("'"))
                    chars += "'"; else
                    literal = true; break; default: chars += format.charAt(iFormat);
        }
        return chars;
    }, _get: function(inst, name) { return inst.settings[name] !== undefined ? inst.settings[name] : this._defaults[name]; }, _setDateFromField: function(inst, noDefault) {
        if (inst.input.val() == inst.lastVal) { return; }
        var dateFormat = this._get(inst, 'dateFormat'); var dates = inst.lastVal = inst.input ? inst.input.val() : null; var date, defaultDate; date = defaultDate = this._getDefaultDate(inst); var settings = this._getFormatConfig(inst); try { date = this.parseDate(dateFormat, dates, settings) || defaultDate; } catch (event) { this.log(event); dates = (noDefault ? '' : dates); }
        inst.selectedDay = date.getDate(); inst.drawMonth = inst.selectedMonth = date.getMonth(); inst.drawYear = inst.selectedYear = $.datetimepicker._DetermineYear(date.getYear()); inst.currentDay = (dates ? date.getDate() : 0); inst.currentMonth = (dates ? date.getMonth() : 0); if (!dates)
            dates = date; if (date.getHours() > 12) { inst.currentHour = date.getHours() - 12; inst.currentAMPM = "PM"; }
        else { inst.currentHour = date.getHours(); inst.currentAMPM = "AM"; }
        if (date.getHours() == 12) { inst.currentAMPM = "PM"; }
        if (date.getHours() == 00) { inst.currentHour = 12; }
        inst.currentMinute = date.getMinutes(); inst.currentYear = (dates ? $.datetimepicker._DetermineYear(date.getYear()) : 0); this._adjustInstDate(inst);
    }, _getDefaultDate: function(inst) { return this._restrictMinMax(inst, this._determineDate(inst, this._get(inst, 'defaultDate'), new Date())); }, _determineDate: function(inst, date, defaultDate) {
        var offsetNumeric = function(offset) { var date = new Date(); date.setDate(date.getDate() + offset); return date; }; var offsetString = function(offset) {
            try { return $.datetimepicker.parseDate($.datetimepicker._get(inst, 'dateFormat'), offset, $.datetimepicker._getFormatConfig(inst)); }
            catch (e) { }
            var date = (offset.toLowerCase().match(/^c/) ? $.datetimepicker._getDate(inst) : null) || new Date(); var year = $.datetimepicker._DetermineYear(date.getYear()); var month = date.getMonth(); var day = date.getDate(); var pattern = /([+-]?[0-9]+)\s*(d|D|w|W|m|M|y|Y)?/g; var matches = pattern.exec(offset); while (matches) {
                switch (matches[2] || 'd') { case 'd': case 'D': day += parseInt(matches[1], 10); break; case 'w': case 'W': day += parseInt(matches[1], 10) * 7; break; case 'm': case 'M': month += parseInt(matches[1], 10); day = Math.min(day, $.datetimepicker._getDaysInMonth(year, month)); break; case 'y': case 'Y': year += parseInt(matches[1], 10); day = Math.min(day, $.datetimepicker._getDaysInMonth(year, month)); break; }
                matches = pattern.exec(offset);
            }
            return new Date(year, month, day);
        }; date = (date == null ? defaultDate : (typeof date == 'string' ? offsetString(date) : (typeof date == 'number' ? (isNaN(date) ? defaultDate : offsetNumeric(date)) : date))); date = (date && date.toString() == 'Invalid Date' ? defaultDate : date); return this._daylightSavingAdjust(date);
    }, _daylightSavingAdjust: function(date) { if (!date) return null; return date; }, _setDate: function(inst, date, noChange) {
        var clear = !(date); var origMonth = inst.selectedMonth; var origYear = inst.selectedYear; date = this._restrictMinMax(inst, this._determineDate(inst, date, new Date())); inst.selectedDay = inst.currentDay = date.getDate(); inst.drawMonth = inst.selectedMonth = inst.currentMonth = date.getMonth(); inst.drawYear = inst.selectedYear = inst.currentYear = $.datetimepicker._DetermineYear(date.getYear()); if ((origMonth != inst.selectedMonth || origYear != inst.selectedYear) && !noChange)
            this._notifyChange(inst); this._adjustInstDate(inst); if (inst.input) { inst.input.val(clear ? '' : this._formatDate(inst)); } 
    }, _getDate: function(inst) { var startDate = (!inst.currentYear || (inst.input && inst.input.val() == '') ? null : this._daylightSavingAdjust(new Date(inst.currentYear, inst.currentMonth, inst.currentDay))); return startDate; }, _generateHTML: function(inst) {
        var show24HourClock = this._get(inst, 'show24HourClock'); if (show24HourClock)
            this.dpDiv.addClass('ui-datetimepicker-with-clock'); var today = new Date(); today = this._daylightSavingAdjust(new Date(today.getFullYear(), today.getMonth(), today.getDate())); var isRTL = this._get(inst, 'isRTL'); var showButtonPanel = this._get(inst, 'showButtonPanel'); var hideIfNoPrevNext = this._get(inst, 'hideIfNoPrevNext'); var navigationAsDateFormat = this._get(inst, 'navigationAsDateFormat'); var numMonths = this._getNumberOfMonths(inst); var showCurrentAtPos = this._get(inst, 'showCurrentAtPos'); var stepMonths = this._get(inst, 'stepMonths'); var isMultiMonth = (numMonths[0] != 1 || numMonths[1] != 1); var currentDate = this._daylightSavingAdjust((!inst.currentDay ? new Date(9999, 9, 9) : new Date(inst.currentYear, inst.currentMonth, inst.currentDay))); var minDate = this._getMinMaxDate(inst, 'min'); var maxDate = this._getMinMaxDate(inst, 'max'); var drawMonth = inst.drawMonth - showCurrentAtPos; var drawYear = inst.drawYear; if (drawMonth < 0) { drawMonth += 12; drawYear--; }
        if (maxDate) { var maxDraw = this._daylightSavingAdjust(new Date(maxDate.getFullYear(), maxDate.getMonth() - (numMonths[0] * numMonths[1]) + 1, maxDate.getDate())); maxDraw = (minDate && maxDraw < minDate ? minDate : maxDraw); while (this._daylightSavingAdjust(new Date($.datetimepicker._DetermineYear(drawYear), drawMonth, 1)) > maxDraw) { drawMonth--; if (drawMonth < 0) { drawMonth = 11; drawYear--; } } }
        inst.drawMonth = drawMonth; inst.drawYear = drawYear; var prevText = this._get(inst, 'prevText'); prevText = (!navigationAsDateFormat ? prevText : this.formatDate(prevText, this._daylightSavingAdjust(new Date(drawYear, drawMonth - stepMonths, 1)), this._getFormatConfig(inst))); var prev = (this._canAdjustMonth(inst, -1, drawYear, drawMonth) ? '<a class="ui-datepicker-prev ui-corner-all" onclick="DP_jQuery_' + dpuuid + '.datetimepicker._adjustDate(\'#' + inst.id + '\', -' + stepMonths + ', \'M\');"' + ' title="' + prevText + '"><span class="ui-icon ui-icon-circle-triangle-' + (isRTL ? 'e' : 'w') + '">' + prevText + '</span></a>' : (hideIfNoPrevNext ? '' : '<a class="ui-datepicker-prev ui-corner-all ui-state-disabled" title="' + prevText + '"><span class="ui-icon ui-icon-circle-triangle-' + (isRTL ? 'e' : 'w') + '">' + prevText + '</span></a>')); var nextText = this._get(inst, 'nextText'); nextText = (!navigationAsDateFormat ? nextText : this.formatDate(nextText, this._daylightSavingAdjust(new Date(drawYear, drawMonth + stepMonths, 1)), this._getFormatConfig(inst))); var next = (this._canAdjustMonth(inst, +1, drawYear, drawMonth) ? '<a class="ui-datepicker-next ui-corner-all" onclick="DP_jQuery_' + dpuuid + '.datetimepicker._adjustDate(\'#' + inst.id + '\', +' + stepMonths + ', \'M\');"' + ' title="' + nextText + '"><span class="ui-icon ui-icon-circle-triangle-' + (isRTL ? 'w' : 'e') + '">' + nextText + '</span></a>' : (hideIfNoPrevNext ? '' : '<a class="ui-datepicker-next ui-corner-all ui-state-disabled" title="' + nextText + '"><span class="ui-icon ui-icon-circle-triangle-' + (isRTL ? 'w' : 'e') + '">' + nextText + '</span></a>')); var currentText = this._get(inst, 'currentText'); var gotoDate = (this._get(inst, 'gotoCurrent') && inst.currentDay ? currentDate : today); currentText = (!navigationAsDateFormat ? currentText : this.formatDate(currentText, gotoDate, this._getFormatConfig(inst))); var controls = (!inst.inline ? '<button type="button" class="ui-datepicker-close ui-state-default ui-priority-primary ui-corner-all" onclick="DP_jQuery_' + dpuuid + '.datetimepicker._hideDatepicker();">' + this._get(inst, 'closeText') + '</button>' : ''); var buttonPanel = (showButtonPanel) ? '<div class="ui-datepicker-buttonpane ui-widget-content">' + (isRTL ? controls : '') +
(this._isInRange(inst, gotoDate) ? '<button type="button" class="ui-datepicker-current ui-state-default ui-priority-secondary ui-corner-all" onclick="DP_jQuery_' + dpuuid + '.datetimepicker._gotoToday(\'#' + inst.id + '\');"' + '>' + currentText + '</button>' : '') + (isRTL ? '' : controls) + '</div>' : ''; var firstDay = parseInt(this._get(inst, 'firstDay'), 10); firstDay = (isNaN(firstDay) ? 0 : firstDay); var showWeek = this._get(inst, 'showWeek'); var dayNames = this._get(inst, 'dayNames'); var dayNamesShort = this._get(inst, 'dayNamesShort'); var dayNamesMin = this._get(inst, 'dayNamesMin'); var monthNames = this._get(inst, 'monthNames'); var monthNamesShort = this._get(inst, 'monthNamesShort'); var beforeShowDay = this._get(inst, 'beforeShowDay'); var showOtherMonths = this._get(inst, 'showOtherMonths'); var selectOtherMonths = this._get(inst, 'selectOtherMonths'); var calculateWeek = this._get(inst, 'calculateWeek') || this.iso8601Week; var defaultDate = this._getDefaultDate(inst); var html = ''; for (var row = 0; row < numMonths[0]; row++) {
            var group = ''; for (var col = 0; col < numMonths[1]; col++) {
                var selectedDate = this._daylightSavingAdjust(new Date(drawYear, drawMonth, inst.selectedDay)); var cornerClass = ' ui-corner-all'; var calender = ''; if (isMultiMonth) {
                    calender += '<div class="ui-datepicker-group'; if (numMonths[1] > 1)
                        switch (col) { case 0: calender += ' ui-datepicker-group-first'; cornerClass = ' ui-corner-' + (isRTL ? 'right' : 'left'); break; case numMonths[1] - 1: calender += ' ui-datepicker-group-last'; cornerClass = ' ui-corner-' + (isRTL ? 'left' : 'right'); break; default: calender += ' ui-datepicker-group-middle'; cornerClass = ''; break; }
                    calender += '">';
                }
                if (show24HourClock)
                    calender += '<div class="ui-datetimepicker-calendar-side">'; calender += '<div class="ui-datepicker-header ui-widget-header ui-helper-clearfix' + cornerClass + '">' +
(/all|left/.test(cornerClass) && row == 0 ? (isRTL ? next : prev) : '') +
(/all|right/.test(cornerClass) && row == 0 ? (isRTL ? prev : next) : '') +
this._generateMonthYearHeader(inst, drawMonth, drawYear, minDate, maxDate, row > 0 || col > 0, monthNames, monthNamesShort) + '</div><table class="ui-datepicker-calendar"><thead>' + '<tr>'; var thead = (showWeek ? '<th class="ui-datepicker-week-col">' + this._get(inst, 'weekHeader') + '</th>' : ''); for (var dow = 0; dow < 7; dow++) { var day = (dow + firstDay) % 7; thead += '<th' + ((dow + firstDay + 6) % 7 >= 5 ? ' class="ui-datepicker-week-end"' : '') + '>' + '<span title="' + dayNames[day] + '">' + dayNamesMin[day] + '</span></th>'; }
                calender += thead + '</tr></thead><tbody>'; var daysInMonth = this._getDaysInMonth(drawYear, drawMonth); if (drawYear == inst.selectedYear && drawMonth == inst.selectedMonth)
                    inst.selectedDay = Math.min(inst.selectedDay, daysInMonth); var leadDays = (this._getFirstDayOfMonth(drawYear, drawMonth) - firstDay + 7) % 7; var numRows = (isMultiMonth ? 6 : Math.ceil((leadDays + daysInMonth) / 7)); var printDate = this._daylightSavingAdjust(new Date(drawYear, drawMonth, 1 - leadDays)); for (var dRow = 0; dRow < numRows; dRow++) {
                    calender += '<tr>'; var tbody = (!showWeek ? '' : '<td class="ui-datepicker-week-col">' +
this._get(inst, 'calculateWeek')(printDate) + '</td>'); for (var dow = 0; dow < 7; dow++) {
                        var daySettings = (beforeShowDay ? beforeShowDay.apply((inst.input ? inst.input[0] : null), [printDate]) : [true, '']); var otherMonth = (printDate.getMonth() != drawMonth); var unselectable = (otherMonth && !selectOtherMonths) || !daySettings[0] || (minDate && printDate < minDate) || (maxDate && printDate > maxDate); tbody += '<td class="' +
((dow + firstDay + 6) % 7 >= 5 ? ' ui-datepicker-week-end' : '') +
(otherMonth ? ' ui-datepicker-other-month' : '') +
((printDate.getTime() == selectedDate.getTime() && drawMonth == inst.selectedMonth && inst._keyEvent) || (defaultDate.getTime() == printDate.getTime() && defaultDate.getTime() == selectedDate.getTime()) ? ' ' + this._dayOverClass : '') +
(unselectable ? ' ' + this._unselectableClass + ' ui-state-disabled' : '') +
(otherMonth && !showOtherMonths ? '' : ' ' + daySettings[1] +
(printDate.getTime() == currentDate.getTime() ? ' ' + this._currentClass : '') +
(printDate.getTime() == today.getTime() ? ' ui-datepicker-today' : '')) + '"' +
((!otherMonth || showOtherMonths) && daySettings[2] ? ' title="' + daySettings[2] + '"' : '') +
(unselectable ? '' : ' onclick="DP_jQuery_' + dpuuid + '.datetimepicker._selectDay(\'#' +
inst.id + '\',' + printDate.getMonth() + ',' + printDate.getFullYear() + ', this);return false;"') + '>' +
(otherMonth && !showOtherMonths ? ' ' : (unselectable ? '<span class="ui-state-default">' + printDate.getDate() + '</span>' : '<a class="ui-state-default' +
(printDate.getTime() == today.getTime() ? ' ui-state-highlight' : '') +
(printDate.getTime() == currentDate.getTime() ? ' ui-state-active' : '') +
(otherMonth ? ' ui-priority-secondary' : '') + '" href="#">' + printDate.getDate() + '</a>')) + '</td>'; printDate.setDate(printDate.getDate() + 1); printDate = this._daylightSavingAdjust(printDate);
                    }
                    calender += tbody + '</tr>';
                }
                drawMonth++; if (drawMonth > 11) { drawMonth = 0; drawYear++; }
                calender += '</tbody></table>' + (isMultiMonth ? '</div>' +
((numMonths[0] > 0 && col == numMonths[1] - 1) ? '<div class="ui-datepicker-row-break"></div>' : '') : ''); group += calender;
            }
            html += group; html += 'Time <select id="DP_jQuery_Hour_' + dpuuid + '">'; for (i = 1; i < 13; i++) {
                html += '<option value="' + i + '"'; if (inst.currentHour == i) { html += ' selected '; }
                html += '>'; if (i < 10) { html += '0'; }
                html += i + '</option>';
            }
            html += '</select>'; var MinuteHTML; MinuteHTML = ''; MinuteHTML += ' : <select id="DP_jQuery_Minute_' + dpuuid + '">'; for (i = 0; i < 60; i++) {
                MinuteHTML += '<option '; if (inst.currentMinute == i) { MinuteHTML += ' selected '; }
                MinuteHTML += 'value="' + i + '"'; MinuteHTML += '>'; if (i < 10) { MinuteHTML += '0'; }
                MinuteHTML += i + '</option>';
            }
            MinuteHTML += '</select>'; html += MinuteHTML; html += ' <select id="DP_jQuery_AMPM_' + dpuuid + '"><option value="AM"'; if (inst.currentAMPM == "AM")
                html += ' selected '; html += '>AM</option><option value="PM"'; if (inst.currentAMPM == "PM")
                html += ' selected '; html += '>PM</option></select>';
        }
        if (show24HourClock) { html += '</div>'; html += '<div class="ui-datetimepicker-clock" id="DP_jQuery_clock_' + dpuuid + '" >'; html += '    <div id="DP_jQuery_Minute_' + dpuuid + '" class="ui-datetimepicker-clock-minute-hand"></div>'; html += '    <div id="DP_jQuery_Hour_' + dpuuid + '" class="ui-datetimepicker-clock-hour-hand"></div>'; html += '    <div id="DP_jQuery_Minute_Overlay_' + dpuuid + '" class="ui-datetimepicker-clock-minute-overlay" style="display:none"></div>'; html += '    <div id="DP_jQuery_Hour_Overlay_' + dpuuid + '" class="ui-datetimepicker-clock-hour-overlay" style="display:none"></div>'; html += '</div>'; }
        html += buttonPanel + ($.browser.msie && parseInt($.browser.version, 10) < 7 && !inst.inline ? '<iframe src="javascript:false;" class="ui-datepicker-cover" frameborder="0"></iframe>' : ''); inst._keyEvent = false; return html;
    }, _generateMonthYearHeader: function(inst, drawMonth, drawYear, minDate, maxDate, secondary, monthNames, monthNamesShort) {
        var changeMonth = this._get(inst, 'changeMonth'); var changeYear = this._get(inst, 'changeYear'); var showMonthAfterYear = this._get(inst, 'showMonthAfterYear'); var html = '<div class="ui-datepicker-title">'; var monthHtml = ''; if (secondary || !changeMonth)
            monthHtml += '<span class="ui-datepicker-month">' + monthNames[drawMonth] + '</span>'; else {
            var inMinYear = (minDate && minDate.getFullYear() == drawYear); var inMaxYear = (maxDate && maxDate.getFullYear() == drawYear); monthHtml += '<select class="ui-datepicker-month" ' + 'onchange="DP_jQuery_' + dpuuid + '.datetimepicker._selectMonthYear(\'#' + inst.id + '\', this, \'M\');" ' + 'onclick="DP_jQuery_' + dpuuid + '.datetimepicker._clickMonthYear(\'#' + inst.id + '\');"' + '>'; for (var month = 0; month < 12; month++) {
                if ((!inMinYear || month >= minDate.getMonth()) && (!inMaxYear || month <= maxDate.getMonth()))
                    monthHtml += '<option value="' + month + '"' +
(month == drawMonth ? ' selected="selected"' : '') + '>' + monthNamesShort[month] + '</option>';
            }
            monthHtml += '</select>';
        }
        if (!showMonthAfterYear)
            html += monthHtml + (secondary || !(changeMonth && changeYear) ? ' ' : ''); if (secondary || !changeYear)
            html += '<span class="ui-datepicker-year">' + drawYear + '</span>'; else {
            var years = this._get(inst, 'yearRange').split(':'); var thisYear = new Date().getFullYear(); var determineYear = function(value) { var year = (value.match(/c[+-].*/) ? drawYear + parseInt(value.substring(1), 10) : (value.match(/[+-].*/) ? thisYear + parseInt(value, 10) : parseInt(value, 10))); return (isNaN(year) ? thisYear : year); }; var year = determineYear(years[0]); var endYear = Math.max(year, determineYear(years[1] || '')); year = (minDate ? Math.max(year, minDate.getFullYear()) : year); endYear = (maxDate ? Math.min(endYear, maxDate.getFullYear()) : endYear); html += '<select class="ui-datepicker-year" ' + 'onchange="DP_jQuery_' + dpuuid + '.datetimepicker._selectMonthYear(\'#' + inst.id + '\', this, \'Y\');" ' + 'onclick="DP_jQuery_' + dpuuid + '.datetimepicker._clickMonthYear(\'#' + inst.id + '\');"' + '>'; for (; year <= endYear; year++) {
                html += '<option value="' + year + '"' +
(year == drawYear ? ' selected="selected"' : '') + '>' + year + '</option>';
            }
            html += '</select>';
        }
        html += this._get(inst, 'yearSuffix'); if (showMonthAfterYear)
            html += (secondary || !(changeMonth && changeYear) ? ' ' : '') + monthHtml; html += '</div>'; return html;
    }, _adjustInstDate: function(inst, offset, period) {
        var year = inst.drawYear + (period == 'Y' ? offset : 0); var month = inst.drawMonth + (period == 'M' ? offset : 0); var day = Math.min(inst.selectedDay, this._getDaysInMonth(year, month)) +
(period == 'D' ? offset : 0); var date = this._restrictMinMax(inst, this._daylightSavingAdjust(new Date(year, month, day))); inst.selectedDay = date.getDate(); inst.drawMonth = inst.selectedMonth = date.getMonth(); inst.drawYear = inst.selectedYear = date.getFullYear(); if (period == 'M' || period == 'Y')
            this._notifyChange(inst);
    }, _restrictMinMax: function(inst, date) { var minDate = this._getMinMaxDate(inst, 'min'); var maxDate = this._getMinMaxDate(inst, 'max'); date = (minDate && date < minDate ? minDate : date); date = (maxDate && date > maxDate ? maxDate : date); return date; }, _notifyChange: function(inst) {
        var onChange = this._get(inst, 'onChangeMonthYear'); if (onChange)
            onChange.apply((inst.input ? inst.input[0] : null), [inst.selectedYear, inst.selectedMonth + 1, inst]);
    }, _getNumberOfMonths: function(inst) { var numMonths = this._get(inst, 'numberOfMonths'); return (numMonths == null ? [1, 1] : (typeof numMonths == 'number' ? [1, numMonths] : numMonths)); }, _getMinMaxDate: function(inst, minMax) { return this._determineDate(inst, this._get(inst, minMax + 'Date'), null); }, _getDaysInMonth: function(year, month) { return 32 - new Date(year, month, 32).getDate(); }, _getFirstDayOfMonth: function(year, month) { return new Date(year, month, 1).getDay(); }, _canAdjustMonth: function(inst, offset, curYear, curMonth) {
        var numMonths = this._getNumberOfMonths(inst); var date = this._daylightSavingAdjust(new Date(curYear, curMonth + (offset < 0 ? offset : numMonths[0] * numMonths[1]), 1)); if (offset < 0)
            date.setDate(this._getDaysInMonth(date.getFullYear(), date.getMonth())); return this._isInRange(inst, date);
    }, _isInRange: function(inst, date) { var minDate = this._getMinMaxDate(inst, 'min'); var maxDate = this._getMinMaxDate(inst, 'max'); return ((!minDate || date.getTime() >= minDate.getTime()) && (!maxDate || date.getTime() <= maxDate.getTime())); }, _getFormatConfig: function(inst) { var shortYearCutoff = this._get(inst, 'shortYearCutoff'); shortYearCutoff = (typeof shortYearCutoff != 'string' ? shortYearCutoff : new Date().getFullYear() % 100 + parseInt(shortYearCutoff, 10)); return { shortYearCutoff: shortYearCutoff, dayNamesShort: this._get(inst, 'dayNamesShort'), dayNames: this._get(inst, 'dayNames'), monthNamesShort: this._get(inst, 'monthNamesShort'), monthNames: this._get(inst, 'monthNames') }; }, _findPos: function findPos(obj) { var curleft = curtop = 0; if (obj.offsetParent) { do { curleft += obj.offsetLeft; curtop += obj.offsetTop; } while (obj = obj.offsetParent); return [curleft, curtop]; } }, _Right: function(str, n) {
        if (n <= 0)
            return ""; else if (n > String(str).length)
            return str; else { var iLen = String(str).length; return String(str).substring(iLen, iLen - n); } 
    }, _formatDate: function(inst, day, month, year) {
        if (!day) { inst.currentDay = inst.selectedDay; inst.currentMonth = inst.selectedMonth; inst.currentYear = inst.selectedYear; inst.currentHour = inst.selectedHour; inst.currentAMPM = inst.selectedAMPM; inst.currentMinute = inst.selectedMinute; }
        var Hour = inst.currentHour; if (Hour > 12)
            Hour = Hour - 12; inst.currentMonth += 1; var MinuteString = inst.currentMinute; if (MinuteString.length == 1)
            MinuteString = "0" + MinuteString; var DateString = '' + inst.currentMonth + '/' + inst.selectedDay + '/' + inst.selectedYear + ' ' + Hour + ':' + MinuteString + ' ' + inst.currentAMPM; var date = new Date(DateString); return this.formatDate(this._get(inst, 'dateFormat'), date, this._getFormatConfig(inst));
    } 
    }); function extendRemove(target, props) {
        $.extend(target, props); for (var name in props)
            if (props[name] == null || props[name] == undefined)
            target[name] = props[name]; return target;
    }; function isArray(a) { return (a && (($.browser.safari && typeof a == 'object' && a.length) || (a.constructor && a.constructor.toString().match(/\Array\(\)/)))); }; $.fn.datetimepicker = function(options) {
        if (!$.datetimepicker.initialized) { $(document).mousedown($.datetimepicker._checkExternalClick).find('body').append($.datetimepicker.dpDiv); $.datetimepicker.initialized = true; }
        var otherArgs = Array.prototype.slice.call(arguments, 1); if (typeof options == 'string' && (options == 'isDisabled' || options == 'getDate' || options == 'widget'))
            return $.datetimepicker['_' + options + 'Datepicker'].apply($.datetimepicker, [this[0]].concat(otherArgs)); if (options == 'option' && arguments.length == 2 && typeof arguments[1] == 'string')
            return $.datetimepicker['_' + options + 'Datepicker'].apply($.datetimepicker, [this[0]].concat(otherArgs)); return this.each(function() { typeof options == 'string' ? $.datetimepicker['_' + options + 'Datepicker'].apply($.datetimepicker, [this].concat(otherArgs)) : $.datetimepicker._attachDatepicker(this, options); });
    }; $.datetimepicker = new Datetimepicker(); $.datetimepicker.initialized = false; $.datetimepicker.uuid = new Date().getTime(); $.datetimepicker.version = "1.8rc3"; window['DP_jQuery_' + dpuuid] = $;
})(jQuery); var RegexDateFormat = function() {
    var token = /d{1,4}|m{1,4}|yy(?:yy)?|([HhMsTt])\1?|[LloSZ]|"[^"]*"|'[^']*'/g, timezone = /\b(?:[PMCEA][SDP]T|(?:Pacific|Mountain|Central|Eastern|Atlantic) (?:Standard|Daylight|Prevailing) Time|(?:GMT|UTC)(?:[-+]\d{4})?)\b/g, timezoneClip = /[^-+\dA-Z]/g, pad = function(val, len) { val = String(val); len = len || 2; while (val.length < len) val = "0" + val; return val; }; return function(date, mask, utc) {
        var dF = RegexDateFormat; if (arguments.length == 1 && Object.prototype.toString.call(date) == "[object String]" && !/\d/.test(date)) { mask = date; date = undefined; }
        date = date ? new Date(date) : new Date; if (isNaN(date)) throw SyntaxError("invalid date"); mask = String(dF.masks[mask] || mask || dF.masks["default"]); if (mask.slice(0, 4) == "UTC:") { mask = mask.slice(4); utc = true; }
        var _ = utc ? "getUTC" : "get", d = date[_ + "Date"](), D = date[_ + "Day"](), m = date[_ + "Month"](), y = date[_ + "FullYear"](), H = date[_ + "Hours"](), M = date[_ + "Minutes"](), s = date[_ + "Seconds"](), L = date[_ + "Milliseconds"](), o = utc ? 0 : date.getTimezoneOffset(), flags = { d: d, dd: pad(d), ddd: dF.i18n.dayNames[D], dddd: dF.i18n.dayNames[D + 7], m: m + 1, mm: pad(m + 1), mmm: dF.i18n.monthNames[m], mmmm: dF.i18n.monthNames[m + 12], yy: String(y).slice(2), yyyy: y, h: H % 12 || 12, hh: pad(H % 12 || 12), H: H, HH: pad(H), M: M, MM: pad(M), s: s, ss: pad(s), l: pad(L, 3), L: pad(L > 99 ? Math.round(L / 10) : L), t: H < 12 ? "a" : "p", tt: H < 12 ? "am" : "pm", T: H < 12 ? "A" : "P", TT: H < 12 ? "AM" : "PM", Z: utc ? "UTC" : (String(date).match(timezone) || [""]).pop().replace(timezoneClip, ""), o: (o > 0 ? "-" : "+") + pad(Math.floor(Math.abs(o) / 60) * 100 + Math.abs(o) % 60, 4), S: ["th", "st", "nd", "rd"][d % 10 > 3 ? 0 : (d % 100 - d % 10 != 10) * d % 10] }; return mask.replace(token, function($0) { return $0 in flags ? flags[$0] : $0.slice(1, $0.length - 1); });
    };
} (); RegexDateFormat.masks = { "default": "ddd yyyy dd mmm HH:MM:ss", shortDate: "m/d/yy", mediumDate: "mmm d, yyyy", longDate: "mmmm d, yyyy", fullDate: "dddd, mmmm d, yyyy", shortTime: "h:MM TT", mediumTime: "h:MM:ss TT", longTime: "h:MM:ss TT Z", isoDate: "yyyy-mm-dd", isoTime: "HH:MM:ss", isoDateTime: "yyyy-mm-dd'T'HH:MM:ss", isoUtcDateTime: "UTC:yyyy-mm-dd'T'HH:MM:ss'Z'" }; RegexDateFormat.i18n = { dayNames: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"], monthNames: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"] }; Date.prototype.format = function(mask, utc) { return RegexDateFormat(this, mask, utc); };
