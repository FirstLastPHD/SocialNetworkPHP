var BlankonApp = function(){

return {

// =========================================================================
// CONSTRUCTOR APP
// =========================================================================
init: function () {
BlankonApp.handleBaseURL();
BlankonApp.handleIE();
BlankonApp.handleSidebarNavigation();
BlankonApp.handleSidebarScroll();
BlankonApp.handleSidebarResponsive();
BlankonApp.handlePanelScroll();
BlankonApp.handleTooltip();
BlankonApp.handlePopover();
BlankonApp.handleCopyrightYear();
},

// =========================================================================
// SET UP BASE URL
// =========================================================================
handleBaseURL: function () {
var getUrl = window.location,
baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
return baseUrl;
},

// =========================================================================
// IE SUPPORT
// =========================================================================
handleIE: function () {
// IE mode
var isIE8 = false;
var isIE9 = false;
var isIE10 = false;

// initializes main settings for IE
isIE8 = !! navigator.userAgent.match(/MSIE 8.0/);
isIE9 = !! navigator.userAgent.match(/MSIE 9.0/);
isIE10 = !! navigator.userAgent.match(/MSIE 10.0/);

if (isIE10) {
$('html').addClass('ie10'); // detect IE10 version
}

if (isIE10 || isIE9 || isIE8) {
$('html').addClass('ie'); // detect IE8, IE9, IE10 version
}

// Fix input placeholder issue for IE8 and IE9
if (isIE8 || isIE9) { // ie8 & ie9
// this is html5 placeholder fix for inputs, inputs with placeholder-no-fix class will be skipped(e.g: we need this for password fields)
$('input[placeholder]:not(.placeholder-no-fix), textarea[placeholder]:not(.placeholder-no-fix)').each(function () {
    var input = $(this);

    if (input.val() == '' && input.attr("placeholder") != '') {
        input.addClass("placeholder").val(input.attr('placeholder'));
    }

    input.focus(function () {
        if (input.val() == input.attr('placeholder')) {
            input.val('');
        }
    });

    input.blur(function () {
        if (input.val() == '' || input.val() == input.attr('placeholder')) {
            input.val(input.attr('placeholder'));
        }
    });
});
}
},

// =========================================================================
// CHECK COOKIE
// =========================================================================
handleCheckCookie: function () {
// Check (onLoad) if the cookie is there and set the class if it is
// Set cookie sidebar minimize page
if ($.cookie('page_sidebar_minimize') == 'active') {
$('body').addClass('page-sidebar-minimize');
}
},

// =========================================================================
// SIDEBAR NAVIGATION
// =========================================================================
handleSidebarNavigation: function () {
// Create trigger click for open menu sidebar
$('.submenu > a').click(function() {
var parentElement = $(this).parent('.submenu'),
    nextElement = $(this).nextAll(),
    arrowIcon = $(this).find('.arrow'),
    plusIcon = $(this).find('.plus');

// Add effect sound button click
if($('.page-sound').length){
    ion.sound.play("button_click_on");
}

if(parentElement.parent('ul').find('ul:visible')){
    parentElement.parent('ul').find('ul:visible').slideUp('fast');
    parentElement.parent('ul').find('.open').removeClass('open');
}

if(nextElement.is('ul:visible')) {
    arrowIcon.removeClass('open');
    plusIcon.removeClass('open');
    nextElement.slideUp('fast');
    arrowIcon.removeClass('fa-angle-double-down').addClass('fa-angle-double-right');
}

if(!nextElement.is('ul:visible')) {
    arrowIcon.addClass('open');
    plusIcon.addClass('open');
    nextElement.slideDown('fast');
    arrowIcon.removeClass('fa-angle-double-right').addClass('fa-angle-double-down');
}

});
},

// =========================================================================
// SIDEBAR LEFT NICESCROLL
// =========================================================================
handleSidebarScroll: function () {
// Optimalisation: Store the references outside the event handler:
function checkHeightSidebar() {
// Check if there is class page-sidebar-fixed
if($('.page-sidebar-fixed').length){
    // Setting dinamic height sidebar menu
    var heightSidebarLeft       = $(window).outerHeight() - $('#header').outerHeight() - $('.sidebar-footer').outerHeight() - $('.sidebar-content').outerHeight();

    $('#sidebar-left .sidebar-menu').height(heightSidebarLeft)
        .niceScroll({
            cursorwidth: '10px',
            cursorborder: '0px',
            railalign: 'left'
        });
}

var heightSidebarRight      = $(window).outerHeight() - $('#sidebar-right .panel-heading').outerHeight(),
    heightSidebarRightChat  = $(window).outerHeight() - $('#sidebar-right .panel-heading').outerHeight() - $('#sidebar-chat .form-horizontal').outerHeight();

// Sidebar right profile
$('#sidebar-profile .sidebar-menu').height(heightSidebarRight)
    .niceScroll({
        cursorwidth: '10px',
        cursorborder: '0px'
    });

// Sidebar right layout
$('#sidebar-layout .sidebar-menu').height(heightSidebarRight)
    .niceScroll({
        cursorwidth: '10px',
        cursorborder: '0px'
    });

// Sidebar right setting
$('#sidebar-setting .sidebar-menu').height(heightSidebarRight)
    .niceScroll({
        cursorwidth: '10px',
        cursorborder: '0px'
    });

// Sidebar right chat
$('#sidebar-chat .sidebar-menu').height(heightSidebarRightChat)
    .niceScroll({
        cursorwidth: '10px',
        cursorborder: '0px'
    });

}
// Execute on load
checkHeightSidebar();
// Bind event listener
$(window).resize(checkHeightSidebar);
},

// =========================================================================
// SIDEBAR RESPONSIVE
// =========================================================================
handleSidebarResponsive: function () {
// Optimalisation: Store the references outside the event handler:
var $window = $(window);
function checkWidth() {
var windowsize = $window.width();
// Check if view screen on greater then 720px and smaller then 1024px
if (windowsize > 768 && windowsize <= 1024) {
    $('body').addClass('page-sidebar-minimize-auto');
}
else if (windowsize <= 768) {
    $('body').removeClass('page-sidebar-minimize');
    $('body').removeClass('page-sidebar-minimize-auto');
}
else{
    $('body').removeClass('page-sidebar-minimize-auto');
}
}
// Execute on load
checkWidth();
// Bind event listener
$(window).resize(checkWidth);

// When the minimize trigger is clicked
$('.navbar-minimize a').on('click',function(){

// Add effect sound button click
if($('.page-sound').length){
    ion.sound.play("button_click");
}

// Check class sidebar right show
if($('.page-sidebar-right-show').length){
    $('body').removeClass('page-sidebar-right-show');
}

// Check class sidebar minimize auto
if($('.page-sidebar-minimize-auto').length){
    $('body').removeClass('page-sidebar-minimize-auto');
}else{
    // Toggle the class to the body
    $('body').toggleClass('page-sidebar-minimize');
}

// Check the current cookie value
// If the cookie is empty or set to not active, then add page_sidebar_minimize
if ($.cookie('page_sidebar_minimize') == "undefined" || $.cookie('page_sidebar_minimize') == "not_active") {

    // Set cookie value to active
    $.cookie('page_sidebar_minimize','active', {expires: 1});
}

// If the cookie was already set to active then remove it
else {

    // Remove cookie with name page_sidebar_minimize
    $.removeCookie('page_sidebar_minimize');

    // Create cookie with value to not_active
    $.cookie('page_sidebar_minimize','not_active',  {expires: 1});

}

});

$('.navbar-setting a').on('click',function(){
// Add effect sound button click
if($('.page-sound').length){
    ion.sound.play("button_click");
}
if($('.page-sidebar-minimize.page-sidebar-right-show').length){
    $('body').toggleClass('page-sidebar-minimize page-sidebar-right-show');
}
else if($('.page-sidebar-minimize').length){
    $('body').toggleClass('page-sidebar-right-show');
}else{
    $('body').toggleClass('page-sidebar-minimize page-sidebar-right-show');
}
});

// This action available on mobile view
$('.navbar-minimize-mobile.left').on('click',function(){
// Add effect sound button click
if($('.page-sound').length){
    ion.sound.play("button_click");
}
if($('body.page-sidebar-right-show').length){
    $('body').removeClass('page-sidebar-right-show');
    $('body').removeClass('page-sidebar-minimize');
}
$('body').toggleClass('page-sidebar-left-show');
});
$('.navbar-minimize-mobile.right').on('click',function(){
// Add effect sound button click
if($('.page-sound').length){
    ion.sound.play("button_click");
}
if($('body.page-sidebar-left-show').length){
    $('body').removeClass('page-sidebar-left-show');
    $('body').removeClass('page-sidebar-minimize');
}
$('body').toggleClass('page-sidebar-right-show');
});
},

// =========================================================================
// PANEL NICESCROLL
// =========================================================================
handlePanelScroll: function () {
if($('.panel-scrollable').length){
$('.panel-scrollable .panel-body').niceScroll({
    cursorwidth: '10px',
    cursorborder: '0px'
});
}
},

// =========================================================================
// TOOLTIP
// =========================================================================
handleTooltip: function () {
if($('[data-toggle=tooltip]').length){
$('[data-toggle=tooltip]').tooltip({
    animation: 'fade'
});
}
},

// =========================================================================
// POPOVER
// =========================================================================
handlePopover: function () {
if($('[data-toggle=popover]').length){
$('[data-toggle=popover]').popover();
}
},

// =========================================================================
// COPYRIGHT YEAR
// =========================================================================
handleCopyrightYear : function () {
if($('#copyright-year').length){
var today = new Date();
$('#copyright-year').text(today.getFullYear());
}
}

};
}();

// Call main app init
BlankonApp.init();
