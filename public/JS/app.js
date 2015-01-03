/*global window,Ember */


$(function() {

    // <editor-fold defaultstate="collapsed" desc="Helpers" >     
    var WEB_ROOT = $('#WEB_ROOT').val();

    function prettifyName(name) {
        name = name.replace(/\./g, '');
        name = name.replace(/[^a-zA-Z0-9 ]/g, ' ');
        name = name.replace(/\s+/g, ' ');
        name = name.trim();
        name = name.replace(/\s+/g, '-');
        return encodeURIComponent(name);
    }

    function updateMeta(title, description, url, image) {
        title = title + ' | Mumbai University Result Tracker | Jugal Thakkar';

        document.title = title;
        Ember.$('meta[name=canonical]').attr('href', url);
        Ember.$('meta[name=description]').attr('content', description);
        Ember.$('meta[property=og\\:title]').attr('content', title);
        Ember.$('meta[property=og\\:description]').attr('content', description);
        Ember.$('meta[property=og\\:url]').attr('content', url);
        Ember.$('meta[property=og\\:image]').attr('content', WEB_ROOT + 'images/fb_' + image + '.png');
    }


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

    Handlebars.registerHelper('prettifyName', function(property, options) {
        return  prettifyName(Ember.get(options.data.view.content, property));
    });


    //</editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Application">     

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
        this.route('android', {path: '/android'});
        this.route('loading', {path: '/loading'});
        this.route('visualization', {path: '/visualization'});
        this.resource('results', {path: '/results/:count'});
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
                    if (!Murt.landingPage) {
                        $('.masthead .information').transition('scale in', 1000);
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

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Index">   

    Murt.IndexView = Ember.View.extend({
        classNames: ['ui very relaxed stackable page grid'],
        tagName: 'div',
        templateName: 'index'
    }, Murt.ScrollToMixin);
    Murt.IndexRoute = Ember.Route.extend({
        model: function() {
            updateMeta('Latest Results', 'Track the latest Mumbai University Results as they happen. We have a history of being faster than the university site.Just Saying!', WEB_ROOT + '#!/', 'index');
            return Ember.$.getJSON(WEB_ROOT + 'Services.php?s=get&count=' + 10);
        }
    });


    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Results">   


    Murt.ResultsView = Ember.View.extend({
        classNames: ['ui very relaxed stackable page grid'],
        tagName: 'div',
        templateName: 'results'
    }, Murt.ScrollToMixin);

    Murt.ResultsRoute = Ember.Route.extend({
        model: function(params) {
            updateMeta('All Results', 'View all of the latest results at once.', WEB_ROOT + '#!/results/300', 'results');
            return Ember.$.getJSON(WEB_ROOT + 'Services.php?s=get&count=' + params.count);
        }
    });


    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Result">   


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
            return Ember.$.getJSON(WEB_ROOT + 'Services.php?s=getExam&id=' + params.Id).then(function(response) {

                updateMeta(response.ExamName, 'Result for ' + response.ExamName, WEB_ROOT + '#!/result/' + response.Id + '/' + prettifyName(response.ExamName), 'result');
                return {
                    name: response.ExamName,
                    id: response.Id,
                    selectedMonth: monthOptions[0].value,
                    isInput: true,
                    isLoading: false
                };
            });
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

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Android">   

    Murt.AndroidRoute = Ember.Route.extend({
        model: function() {
            updateMeta('MURT Android App', 'Mumbai University Result Tracker\'s very own Android App. Download Here.', WEB_ROOT + '#!/android', 'android');
            return {androidDownloadCount: this.modelFor('application').androidDownloadCount};
        }
    });
    Murt.AndroidView = Ember.View.extend({
        classNames: ['ui very relaxed stackable page grid'],
        tagName: 'div',
        templateName: 'android'
    }, Murt.ScrollToMixin);

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Visualization">   

    Murt.VisualizationRoute = Ember.Route.extend({
        model: function() {
            updateMeta('Visualization', 'Visualize all results.', WEB_ROOT + '#!/visualization', 'visualization');
        }
    });
    Murt.VisualizationView = Ember.View.extend({
        classNames: ['ui very relaxed stackable page grid'],
        tagName: 'div',
        templateName: 'visualization'
    }, Murt.ScrollToMixin);

    // </editor-fold>

});
