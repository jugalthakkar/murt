/*global window,Ember */


$(function() {
    function scrollToAnchor(aid) {
        var aTag = $(aid);
        $('html,body').animate({scrollTop: aTag.offset().top}, 'slow');
    }
    Handlebars.registerHelper('readableTime', function(property, options) {
        return  moment(parseInt(Ember.get(options.data.view.content, property)) * 1000).fromNow();
    });
    Handlebars.registerHelper('longTime', function(property, options) {
        return  new Date(parseInt(Ember.get(options.data.view.content, property)) * 1000).toString();
    });

    var WEB_ROOT = $('#WEB_ROOT').val();

    /************************ Application Start *******************************************/

    window.Murt = Ember.Application.create(
        {
            rootElement: '#murt-app',
            LOG_TRANSITIONS: true
        }
    );

    //var get = Ember.get, set = Ember.set;


    Murt.register('location:hashbang', Ember.HashLocation.extend({
        getURL: function() {
            return Ember.get(this, 'location').hash.substr(2);
        },
        setURL: function(path) {
            Ember.get(this, 'location').hash = "!" + path;
            Ember.set(this, 'lastSetURL', "!" + path);
        },
        onUpdateURL: function(callback) {
            var self = this;
            var guid = Ember.guidFor(this);

            Ember.$(window).bind('hashchange.ember-location-' + guid, function() {
                Ember.run(function() {
                    var path = location.hash.substr(2);
                    if (Ember.get(self, 'lastSetURL') === path) {
                        return;
                    }

                    Ember.set(self, 'lastSetURL', null);

                    callback(location.hash.substr(2));
                });
            });
        },
        formatURL: function(url) {
            return '#!' + url;
        }
    }));

    Murt.Router.reopen({
        location: 'hashbang'
    });
    Murt.Router.map(function() {
        this.resource('android', {path: '/android'});
        this.resource('loading', {path: '/loading'});
        this.resource('results', {path: '/results'});
        this.resource('result', {path: '/result/:Id/:ExamName'});
    });

    Murt.ApplicationView = Ember.View.extend({
        tagName: 'div',
        templateName: 'application'
    });
    Murt.ApplicationRoute = Ember.Route.extend({
        model: function() {
            return {
                currentYear: new Date().getFullYear(),
                androidDownloadCount: $('#androidDownloadCount').val(),
                hitCount: $('#hitCount').val()
            };
        }
    });
    Murt.ApplicationController = Ember.Controller.extend({
        actions: {
            onShowResult: function() {
                scrollToAnchor('#outlet');
            }
        }
    });
    Murt.ScrollToMixin = Ember.Mixin.create({
        setupScrollToOutlet: function() {
            Ember.run.scheduleOnce('afterRender', this,
                function() {

                    $('.ui.dropdown').dropdown({on: 'click'});
                    //$('#fixedMenu').prependTo('body');
                    //$('.ui.form').form(validationRules, {on: 'blur'});

                    $('.masthead .information').transition('scale in', 1000);
                    if (!Murt.landingPage) {
                        Murt.landingPage = window.location;
                    } else {
                        scrollToAnchor('#outlet');
                    }

                    //var position = this.$().offset().top;
                    //$('html,body').animate({scrollTop: position},'slow');
                    //window.scrollTo(0, position);
                });
        }.on('didInsertElement')
    });
    /************************ Application End *******************************************/

    /************************************************************************************************************/

    /************************ Index Start *******************************************/


    Murt.IndexView = Ember.View.extend({
        classNames: ['ui very relaxed stackable page grid'],
        tagName: 'div',
        templateName: 'index'
    }, Murt.ScrollToMixin);
    Murt.IndexRoute = Ember.Route.extend({
        model: function() {
            return JSON.parse($('#lastTenResults').val());
        }
    });

    /************************ Index End *******************************************/

    /************************************************************************************************************/


    /************************ Results Start *******************************************/


    Murt.ResultsView = Ember.View.extend({
        classNames: ['ui very relaxed stackable page grid'],
        tagName: 'div',
        templateName: 'results'
    }, Murt.ScrollToMixin);

    Murt.ResultsRoute = Ember.Route.extend({
        model: function() {
            return $.getJSON(WEB_ROOT + 'Services.php?s=get&count=300');
        }
    });

    /************************ Results End *******************************************/

    /************************************************************************************************************/



    /************************ Result Start *******************************************/

    var months = moment().localeData()._months;
    var now = new Date();
//    var defaultDate = new Date();
    //defaultDate.setDate(defaultDate.getDate() - 90);
//    var defaultYear = defaultDate.getFullYear();
//    var defaultMonth = months[defaultDate.getMonth()];

    var currYear = parseInt(now.getFullYear());
    var currMonth = now.getMonth();
    var monthOptions = [
        {
            display: "Month of Exam",
            value: ""
        }
    ];
    for (var i = 0; i < 6; i++) {
        monthOptions.push({
            display: months[currMonth] + " - " + currYear,
            value: months[currMonth] + " - " + currYear,
            month: months[currMonth],
            year: currYear
        });
        if (currMonth === 0) {
            currMonth = 11;
            currYear--;
        } else {
            currMonth--;
        }
    }


    Murt.ResultRoute = Ember.Route.extend({
        model: function(params) {
            return {
                name: params.ExamName,
                id: params.Id,
                selectedMonth: monthOptions[0].value,
                isInput: true,
                isLoading: false
            };
        }
    });
    Murt.ResultView = Ember.View.extend({
        classNames: ['ui very relaxed stackable page grid'],
        tagName: 'div',
        templateName: 'result',
        didInsertElement: function() {
            $('#examInputs')
                .form({
                    seat: {
                        identifier: 'seat',
                        rules: [
                            {
                                type: 'empty',
                                prompt: 'Please enter Seat Number'
                            },
                            {
                                type: 'integer',
                                prompt: 'Only Numeric Values are Allowed'
                            }
                        ]
                    },
                    month: {
                        identifier: 'month',
                        rules: [
                            {
                                type: 'empty',
                                prompt: 'Please select the month of Examination'
                            }
                        ]
                    }
                }, {
                    inline: true
                });
            $('input[name="seat"]').focus();
        }
    }, Murt.ScrollToMixin);
    Murt.ResultController = Ember.ObjectController.extend({
        actions: {
            GetResult: function() {
                if ($('#examInputs').form('validate form')) {
                    this.set('isInput', false);
                    this.set('isLoading', true);
                    //this.model.isInput=false;
                    var data = {
                        s: 'result',
                        exam_month: this.model.selectedMonth.split(' - ')[0],
                        exam_year: this.model.selectedMonth.split(' - ')[1],
                        seat_no: this.model.seat,
                        exam_id: this.model.id
                    };
                    var ctrl = this;
                    $.getJSON(WEB_ROOT + 'Services.php', data).then(
                        function(response) {
                            ctrl.set('isLoading', false);
                            ctrl.set('result', response.result);
                        }
                    );
                }
            }
        },
        monthOptions: monthOptions
    });
    /************************ Result End *******************************************/

    /************************************************************************************************************/


    /************************ Android Start *******************************************/


    Murt.AndroidRoute = Ember.Route.extend({
        model: function() {
            return {androidDownloadCount: this.modelFor('application').androidDownloadCount};
        }
    });
    Murt.AndroidView = Ember.View.extend({
        classNames: ['ui very relaxed stackable page grid'],
        tagName: 'div',
        templateName: 'android'
    }, Murt.ScrollToMixin);
    /************************ Android End *******************************************/

    /************************************************************************************************************/

});
