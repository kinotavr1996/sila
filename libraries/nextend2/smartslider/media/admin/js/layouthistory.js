
(function (smartSlider, $, scope, undefined) {
    "use strict";

    function pad2(v) {
        return ("0" + v).slice(-2);
    }

    function NextendSmartSliderAdminLayoutHistory() {
        this.states = 5;
        this.$ul = $('.n2-ss-history-list > ul');
        this.history = [];
        this._history = [];
        for (var i = 0; i < this.states; i++) {
            this.history[i] = false;
            this._history[i + 1] = '';
        }

        smartSlider.history = this;

        smartSlider.slide.ready($.proxy(function () {
            var data = smartSlider.slide.getLayout();
            this.addRow(n2_('Saved slide'), data);
            this._history[0] = JSON.stringify(data);
        }, this));
    }

    NextendSmartSliderAdminLayoutHistory.prototype.add = function () {
        this.addWithCheck();
    };

    NextendSmartSliderAdminLayoutHistory.prototype.addWithCheck = function () {
        var data = smartSlider.slide.getLayout();
        if (this._history.indexOf(JSON.stringify(data)) == '-1') {
            this._add(data);
        }
    };

    NextendSmartSliderAdminLayoutHistory.prototype._add = function (data) {
        this.history.unshift(this.addRow(this.getFormattedDate(), data));
        this._history.splice(1, 0, JSON.stringify(data));
        this._history.pop();
        var removeRow = this.history.pop();
        if (removeRow) {
            removeRow.remove();
        }
    };

    NextendSmartSliderAdminLayoutHistory.prototype.getFormattedDate = function () {
        var date = new Date();
        return date.getFullYear() + "-" + pad2(date.getMonth() + 1) + "-" + pad2(date.getDate()) + " " + pad2(date.getHours()) + ":" + pad2(date.getMinutes()) + ":" + pad2(date.getSeconds());
    };

    NextendSmartSliderAdminLayoutHistory.prototype.addRow = function (title, data) {
        return $('<li></li>')
            .append($('<a href="#">' + title + '</a>')
                .on('click', $.proxy(function (data, e) {
                    this.addWithCheck();
                    smartSlider.slide.loadLayout(data, true, true);
                    e.preventDefault();
                }, this, data)))
            .appendTo(this.$ul)
    };

    scope.NextendSmartSliderAdminLayoutHistory = NextendSmartSliderAdminLayoutHistory;

})(nextend.smartSlider, n2, window);
