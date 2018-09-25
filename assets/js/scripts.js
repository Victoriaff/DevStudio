(function ($) {
    var DevStudio = {


        module: null,
        component: null,
        unit: null,

        // Containers
        $modules: null,
        $components: null,
        $units: null,

        response: {},

        init: function () {

            //console.log(this);
            $(document).ready(function () {


                $('body').on('click', '#dev-studio .on-off', function (e) {
                   $(this).toggleClass('off');
                   if ($(this).hasClass('off')) {
                       $('#dev-studio').addClass('off');
                   } else {
                       $('#dev-studio').removeClass('off');
                   }
                });


                // Load UI
                DevStudio.UI();


                // Show/Hide UI
                $('#wp-admin-bar-dev-studio a').on('click', function (e) {
                    e.preventDefault();
                    $('#dev-studio').toggle();
                });

                $('#dev-studio').css({
                    top: $('#wpadminbar').height(),
                    bottom: 0
                });

                // Click on module tab
                $('body').on('click', '#dev-studio .tab-module:not(.active)', function() {
                    $('#dev-studio .tab-module').removeClass('active');
                    $('#dev-studio .tabs-components .component').removeClass('active');
                    $('#dev-studio .tabs-units .unit').removeClass('active');

                    $(this).addClass('active');

                    DevStudio.buildUI();
                    DevStudio.loadData();
                });

                // Click on component tab
                $('body').on('click', '#dev-studio .tabs-components .component:not(.active)', function() {
                    $('#dev-studio .tabs-components .component').removeClass('active');
                    $('#dev-studio .tabs-units .unit').removeClass('active');

                    $(this).addClass('active');

                    DevStudio.buildUI();
                    DevStudio.loadData();
                });

                // Click on unit tab
                $('body').on('click', '#dev-studio .tabs-units .unit:not(.active)', function() {
                    $('#dev-studio .tabs-units .unit').removeClass('active');
                    $(this).addClass('active');

                    DevStudio.setCondition();
                    DevStudio.loadData();
                });

            });
        },

        // Load UI
        UI: function () {
            this.ajax({request: 'UI'}, 'UICallback');
        },
        UICallback: function () {
            console.log(this);
            $('body').append(this.response.html);

            // Show on full screen
            $('#dev-studio').css({top: $('#wpadminbar').height(), bottom: 0});

            this.buildUI();
            DevStudio.loadData();
        },

        buildUI: function() {
            this.$modules = $('#dev-studio .modules');
            this.$components = $('#dev-studio .tabs-components');
            this.$units = $('#dev-studio .tabs-units');

            this.setCondition();

            this.$components.html('');
            this.$units.html('');

            // Show components and units
            var html = '', units_html = '';
            $.each(DSData.map, function(key, module) {
                if (key == DevStudio.module) {
                    $.each(module.components, function(key, component) {
                        if (DevStudio.component == undefined) DevStudio.component = key;
                        html += '<div class="component '+(key == DevStudio.component ? 'active':'')+'" data-component="' + key + '">' + component.title + '</div>';

                        if (key == DevStudio.component) {
                            $.each(component.units, function(key, unit) {
                                if (DevStudio.unit == undefined) DevStudio.unit = key;
                                units_html += '<div class="unit '+(key == DevStudio.unit ? 'active':'')+'" data-unit="' + key + '">' + unit.title + '</div>';
                            });
                        }
                    });
                    DevStudio.$components.html(html);
                    console.log(units_html);
                    DevStudio.$units.html(units_html);
                }
            });

            /*
            if ($('#dev-studio .tabs-components .component.active').length == 0) {
                $('#dev-studio .tabs-components .component').first().addClass('active');
            }
            if ($('#dev-studio .tabs-units .unit.active').length == 0) {
                $('#dev-studio .tabs-units .unit').first().addClass('active');
            }
            */



            //console.log($('#dev-studio .tab-module.active').data('module'));
            //this.module = $('#dev-studio .tab-module.active').data('module');
            //console.log(this.module );
            //console.log(DSData);

            //this.map();
        },

        // Load data
        loadData: function () {
            this.setCondition();

            var dot_unit = this.module + '.' + this.component + '.' + this.unit;
            this.ajax({
                request: 'data',
                checkpoint: $('#checkpoint').val(),
                dot_unit: dot_unit
            }, 'loadDataCallback');
        },
        loadDataCallback: function () {
            if (this.response.html) {
                $('#dev-studio-data').html(this.response.html);
            } else {
                $('#dev-studio-data').html('');
            }
        },

        ajax: function (args, callback) {
            var data = {
                action: 'dev_studio',
            }
            data = obj = Object.assign({}, data, args);
            //console.log(data);

            $.ajax({
                url: DSData.ajax_url,
                type: "POST",
                dataType: 'json',
                data: data,
                success: function (response) {
                    console.log(response);
                    DevStudio.response = response;

                    if (response.result == 'ok') {

                        if (callback != undefined) DevStudio[callback]();

                        //$('#dev_studio .data').show().html(response.html);
                        //dev_studio_data_height();
                    }


                }
            });
        },

        setCondition: function() {
            this.module = $('#dev-studio .tab-module.active').data('module');
            this.component = $('#dev-studio .tabs-components .component.active').data('component');
            this.unit = $('#dev-studio .tabs-units .unit.active').data('unit');
        }

    }

    DevStudio.init();
})(window.jQuery);
