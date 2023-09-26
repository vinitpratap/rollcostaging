function init_sidebar() {
    var a = function() {
        $RIGHT_COL.css("min-height", $(window).height());
        var a = $BODY.outerHeight(),
            b = $BODY.hasClass("footer_fixed") ? -10 : $FOOTER.height(),
            c = $LEFT_COL.eq(1).height() + $SIDEBAR_FOOTER.height(),
            d = a < c ? c : a;
        d -= $NAV_MENU.height() + b, $RIGHT_COL.css("min-height", d)
    };
    $SIDEBAR_MENU.find("a").on("click", function(b) {
        var c = $(this).parent();
        c.is(".active") ? (c.removeClass("active active-sm"), $("ul:first", c).slideUp(function() {
            a()
        })) : (c.parent().is(".child_menu") ? $BODY.is(".nav-sm") && ($SIDEBAR_MENU.find("li").removeClass("active active-sm"), $SIDEBAR_MENU.find("li ul").slideUp()) : ($SIDEBAR_MENU.find("li").removeClass("active active-sm"), $SIDEBAR_MENU.find("li ul").slideUp()), c.addClass("active"), $("ul:first", c).slideDown(function() {
            a()
        }))
    }), $MENU_TOGGLE.on("click", function() {
        $BODY.hasClass("nav-md") ? ($SIDEBAR_MENU.find("li.active ul").hide(), $SIDEBAR_MENU.find("li.active").addClass("active-sm").removeClass("active")) : ($SIDEBAR_MENU.find("li.active-sm ul").show(), $SIDEBAR_MENU.find("li.active-sm").addClass("active").removeClass("active-sm")), $BODY.toggleClass("nav-md nav-sm"), a()
    }), $SIDEBAR_MENU.find('a[href="' + CURRENT_URL + '"]').parent("li").addClass("current-page"), $SIDEBAR_MENU.find("a").filter(function() {
        return this.href == CURRENT_URL
    }).parent("li").addClass("current-page").parents("ul").slideDown(function() {
        a()
    }).parent().addClass("active"), $(window).smartresize(function() {
        a()
    }), a(), $.fn.mCustomScrollbar && $(".menu_fixed").mCustomScrollbar({
        autoHideScrollbar: !0,
        theme: "minimal",
        mouseWheel: {
            preventDefault: !0
        }
    })
}

function countChecked() {
    "all" === checkState && $(".bulk_action input[name='table_records']").iCheck("check"), "none" === checkState && $(".bulk_action input[name='table_records']").iCheck("uncheck");
    var a = $(".bulk_action input[name='table_records']:checked").length;
    a ? ($(".column-title").hide(), $(".bulk-actions").show(), $(".action-cnt").html(a + " Records Selected")) : ($(".column-title").show(), $(".bulk-actions").hide())
}

function gd(a, b, c) {
    return new Date(a, b - 1, c).getTime()
}

function init_flot_chart() {
    if ("undefined" != typeof $.plot) {
        console.log("init_flot_chart");
        for (var a = [
                [gd(2012, 1, 1), 17],
                [gd(2012, 1, 2), 74],
                [gd(2012, 1, 3), 6],
                [gd(2012, 1, 4), 39],
                [gd(2012, 1, 5), 20],
                [gd(2012, 1, 6), 85],
                [gd(2012, 1, 7), 7]
            ], b = [
                [gd(2012, 1, 1), 82],
                [gd(2012, 1, 2), 23],
                [gd(2012, 1, 3), 66],
                [gd(2012, 1, 4), 9],
                [gd(2012, 1, 5), 119],
                [gd(2012, 1, 6), 6],
                [gd(2012, 1, 7), 9]
            ], d = [], e = [
                [0, 1],
                [1, 9],
                [2, 6],
                [3, 10],
                [4, 5],
                [5, 17],
                [6, 6],
                [7, 10],
                [8, 7],
                [9, 11],
                [10, 35],
                [11, 9],
                [12, 12],
                [13, 5],
                [14, 3],
                [15, 4],
                [16, 9]
            ], f = 0; f < 30; f++) d.push([new Date(Date.today().add(f).days()).getTime(), randNum() + f + f + 10]);
        var g = {
                series: {
                    lines: {
                        show: !1,
                        fill: !0
                    },
                    splines: {
                        show: !0,
                        tension: .4,
                        lineWidth: 1,
                        fill: .4
                    },
                    points: {
                        radius: 0,
                        show: !0
                    },
                    shadowSize: 2
                },
                grid: {
                    verticalLines: !0,
                    hoverable: !0,
                    clickable: !0,
                    tickColor: "#d5d5d5",
                    borderWidth: 1,
                    color: "#fff"
                },
                colors: ["rgba(38, 185, 154, 0.38)", "rgba(3, 88, 106, 0.38)"],
                xaxis: {
                    tickColor: "rgba(51, 51, 51, 0.06)",
                    mode: "time",
                    tickSize: [1, "day"],
                    axisLabel: "Date",
                    axisLabelUseCanvas: !0,
                    axisLabelFontSizePixels: 12,
                    axisLabelFontFamily: "Verdana, Arial",
                    axisLabelPadding: 10
                },
                yaxis: {
                    ticks: 8,
                    tickColor: "rgba(51, 51, 51, 0.06)"
                },
                tooltip: !1
            },
            h = {
                grid: {
                    show: !0,
                    aboveData: !0,
                    color: "#3f3f3f",
                    labelMargin: 10,
                    axisMargin: 0,
                    borderWidth: 0,
                    borderColor: null,
                    minBorderMargin: 5,
                    clickable: !0,
                    hoverable: !0,
                    autoHighlight: !0,
                    mouseActiveRadius: 100
                },
                series: {
                    lines: {
                        show: !0,
                        fill: !0,
                        lineWidth: 2,
                        steps: !1
                    },
                    points: {
                        show: !0,
                        radius: 4.5,
                        symbol: "circle",
                        lineWidth: 3
                    }
                },
                legend: {
                    position: "ne",
                    margin: [0, -25],
                    noColumns: 0,
                    labelBoxBorderColor: null,
                    labelFormatter: function(a, b) {
                        return a + "&nbsp;&nbsp;"
                    },
                    width: 40,
                    height: 1
                },
                colors: ["#96CA59", "#3F97EB", "#72c380", "#6f7a8a", "#f7cb38", "#5a8022", "#2c7282"],
                shadowSize: 0,
                tooltip: !0,
                tooltipOpts: {
                    content: "%s: %y.0",
                    xDateFormat: "%d/%m",
                    shifts: {
                        x: -30,
                        y: -50
                    },
                    defaultTheme: !1
                },
                yaxis: {
                    min: 0
                },
                xaxis: {
                    mode: "time",
                    minTickSize: [1, "day"],
                    timeformat: "%d/%m/%y",
                    min: d[0][0],
                    max: d[20][0]
                }
            },
            i = {
                series: {
                    curvedLines: {
                        apply: !0,
                        active: !0,
                        monotonicFit: !0
                    }
                },
                colors: ["#26B99A"],
                grid: {
                    borderWidth: {
                        top: 0,
                        right: 0,
                        bottom: 1,
                        left: 1
                    },
                    borderColor: {
                        bottom: "#7F8790",
                        left: "#7F8790"
                    }
                }
            };
       
    }
}




function init_skycons() {}
function init_sparklines() {}
function init_parsley() {}

function onAddTag(a) {
    alert("Added a tag: " + a)
}

function onRemoveTag(a) {
    alert("Removed a tag: " + a)
}

function onChangeTag(a, b) {
    alert("Changed a tag: " + b)
}

function init_TagsInput() {
    "undefined" != typeof $.fn.tagsInput && $("#tags_1").tagsInput({
        width: "auto"
    })
}



function init_InputMask() {
    "undefined" != typeof $.fn.inputmask && (console.log("init_InputMask"), $(":input").inputmask())
}


function init_DataTables() {
    if (console.log("run_datatables"), "undefined" != typeof $.fn.DataTable) {
        console.log("init_DataTables");
        var a = function() {
            $("#datatable-buttons").length && $("#datatable-buttons").DataTable({
                dom: "Blfrtip",
                buttons: [{
                    extend: "copy",
                    className: "btn-sm"
                }, {
                    extend: "csv",
                    className: "btn-sm"
                }, {
                    extend: "excel",
                    className: "btn-sm"
                }, {
                    extend: "pdfHtml5",
                    className: "btn-sm"
                }, {
                    extend: "print",
                    className: "btn-sm"
                }],
                responsive: !0
            })
        };
        TableManageButtons = function() {
            "use strict";
            return {
                init: function() {
                    a()
                }
            }
        }(), $("#datatable").dataTable(), $("#datatable-keytable").DataTable({
            keys: !0
        }), $("#datatable-responsive").DataTable(), $("#datatable-scroller").DataTable({
            ajax: "js/datatables/json/scroller-demo.json",
            deferRender: !0,
            scrollY: 380,
            scrollCollapse: !0,
            scroller: !0
        }), $("#datatable-fixed-header").DataTable({
            fixedHeader: !0
        });
        var b = $("#datatable-checkbox");
        b.dataTable({
            order: [
                [1, "asc"]
            ],
            columnDefs: [{
                orderable: !1,
                targets: [0]
            }]
        }), b.on("draw.dt", function() {
            $("checkbox input").iCheck({
                checkboxClass: "icheckbox_flat-green"
            })
        }), TableManageButtons.init()
    }
}

function init_morris_charts() {}

function init_echarts() {}! function(a, b) {
    var c = function(a, b, c) {
        var d;
        return function() {
            function h() {
                c || a.apply(f, g), d = null
            }
            var f = this,
                g = arguments;
            d ? clearTimeout(d) : c && a.apply(f, g), d = setTimeout(h, b || 100)
        }
    };
    jQuery.fn[b] = function(a) {
        return a ? this.bind("resize", c(a)) : this.trigger(b)
    }
}(jQuery, "smartresize");
var CURRENT_URL = window.location.href.split("#")[0].split("?")[0],
    $BODY = $("body"),
    $MENU_TOGGLE = $("#menu_toggle"),
    $SIDEBAR_MENU = $("#sidebar-menu"),
    $SIDEBAR_FOOTER = $(".sidebar-footer"),
    $LEFT_COL = $(".left_col"),
    $RIGHT_COL = $(".right_col"),
    $NAV_MENU = $(".nav_menu"),
    $FOOTER = $("footer"),
    randNum = function() {
        return Math.floor(21 * Math.random()) + 20
    };
 $(document).ready(function() {
    init_sparklines(), init_DataTables(),init_sidebar(), init_chart_doughnut(), init_autocomplete()
});

 /*$(document).ready(function(){init_sparklines(),init_flot_chart(),init_sidebar(),init_wysiwyg(),init_InputMask(),init_JQVmap(),init_cropper(),init_knob(),init_IonRangeSlider(),init_ColorPicker(),init_TagsInput(),init_parsley(),init_daterangepicker(),init_daterangepicker_right(),init_daterangepicker_single_call(),init_daterangepicker_reservation(),init_SmartWizard(),init_EasyPieChart(),init_charts(),init_echarts(),init_morris_charts(),init_skycons(),init_select2(),init_validator(),init_DataTables(),init_chart_doughnut(),init_gauge(),init_PNotify(),init_starrr(),init_calendar(),init_compose(),init_CustomNotification(),init_autosize(),init_autocomplete()});
*/
// And for a doughnut chart
var ctx = document.getElementById("canvasDoughnut").getContext('2d');
var myChart = new Chart(ctx, {
    type: 'doughnut',
data: {
				labels: ["In-Progress", "Pending ", "Closed "],
				datasets: [{
					data: [127, 60, 123],
					backgroundColor: ["#4993ce", "#49c4b1", "#d3ac47"],
					hoverBackgroundColor: ["#4993ce", "#49c4b1", "#d3ac47"]
				}],
				
			},
			options: {

				legend: !1,
				//responsive: !1
			}
  
});
//orderSummary
var ctx = document.getElementById("orderSummary").getContext('2d');
var myChart = new Chart(ctx, {
    type: "line",
			data: {
					labels: ["January", "February", "March", "April", "May", "June", "July"],
					datasets: [{
						label: "Closed Requests",
						backgroundColor: "rgba(131, 225, 199, 0.35)",
						borderColor: "rgba(131, 225, 199, 0.10)",
						pointRadius: 0,
                         borderWidth: .1,					
						data: [31, 74, 6, 39, 20, 85, 7]
					}, {
						label: "Cancelled Requests",
						backgroundColor: "rgba(209, 189, 33, 0.5)",
						borderColor: "rgba(209, 189, 33, 0.75)",
						pointRadius: 0,
            borderWidth: .1,			
						data: [82, 23, 66, 9, 99, 4, 2]
					}]
				},
			options: {

				legend: !1,
				//responsive: !1
			}
  
  
});

//
$(".progress .progress-bar")[0] && $(".progress .progress-bar").progressbar(), $(document).ready(function () {
	if ($(".js-switch")[0]) {
		var a = Array.prototype.slice.call(document.querySelectorAll(".js-switch"));
		a.forEach(function (a) {
			new Switchery(a, {
				color: "#83e0c7"
			})
		})
	}
})
