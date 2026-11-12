<!-- begin::global scripts -->
<script src="vendors/bundle.js"></script>
<link href='https://fonts.googleapis.com/css?family=Bungee Inline' rel='stylesheet'>
<style>
@media (max-width: 595px){
	.ksymbol{
		display: none!important;
	}
}
@media (max-width: 595px){
	.mobksymbol{
		margin-right: 75px!important;
	}
}
main.main-content {
    padding: 12px 15px!important;
}
</style>
<style>
  /* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}
@media (max-width: 768px){
  .fotter_are p{
    font-size: 9px!important;
  }
  .fotter_are{
    width:50%;
  }

} 
@media (max-width: 993px){
   
   
    .side-menu {
        background-color: #fff;
        z-index: 999;
        -webkit-box-shadow: 0 5px 5px -3px rgba(0,0,0,.15);
        -moz-box-shadow: 0 5px 5px -3px rgba(0,0,0,.15);
        box-shadow: 0 5px 5px -3px rgba(0,0,0,.15);
        left: 0%;
        opacity: 1;
        -webkit-transition: left .2s;
        -o-transition: left .2s;
        -moz-transition: left .2s;
        transition: left .2s;
	}
	.side-menu.show {
    left: 0;
    opacity: 1;
}
.side-menu>.container-fluid>.side-menu-body>ul li a{
    padding: 8px 30px 3px;
}
}
@media (max-width: 992px){  
   
   .side-menu {
      display:none;
    }
  .side-menu.show {
    left: 0;
    opacity: 1;
  }
  .side-menu>.container-fluid>.side-menu-body>ul li a{
    padding: 8px 30px 3px;
  }
}
.side-menu-body ul {
   
  overflow-y: scroll!important;
  scrollbar-width: inherit!important;
   
}
.side-menu  .closebtn {
  position: absolute;
  top: 0;
  right: 25px;
  font-size: 36px;
  margin-left: 50px;
}

.openbtn {
  font-size: 20px;
  cursor: pointer;
  background-color: #111;
  color: white;
  padding: 10px 15px;
  border: none;
  margin-left: 10px;
}

.openbtn:hover {
  background-color: #444;
}
ul::-webkit-scrollbar {
  width: 2px;
}

ul::-webkit-scrollbar-track {
  -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
  border-radius: 10px;
}

ul::-webkit-scrollbar-thumb {
  border-radius: 10px;
  -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.5);
}
main.main-content{
	padding:12px 10px;
}

@media(min-width:992px){
	.navbar-nav{
		display:block!important;
		width:100%;
	}
	.userdiv{
		float:right;
	}
	
}
.side-menu>.container-fluid>.side-menu-body>ul li.open>a{
	color: #fff!important;
	background: #000000;
}
.side-menu>.container-fluid>.side-menu-body>ul li a:focus{
	background: unset;
}

@media(max-width:480px){
	nav.navbar .header-logo a img{
		width:100px;
    height:60px;
	}
}
.side-menu>.container-fluid>.side-menu-body>ul li a, .side-menu>.container>.side-menu-body>ul li a, .side-menu>.side-menu-body>ul li a{
	color: #ffffffcc;
}
.side-menu>.container-fluid>.side-menu-body>ul li a:hover{
	background: unset;
}
main.main-content{
	background: #fff;
}
// .alert.alert-success, .alert.alert-danger, .alert.alert-secondary, .alert.alert-warning, .alert.alert-info, .alert.alert-dark, .page-header{
	// background: -webkit-radial-gradient(0% 100%, ellipse cover, rgba(104,128,138,.4) 10%,rgba(138,114,76,0) 40%), linear-gradient(to bottom,  rgba(57,173,219,.25) 0%,rgba(42,60,87,.4) 100%), linear-gradient(135deg,  #670d10 0%,#092756 100%)!important;
// }
.alert.alert-success, .alert.alert-danger, .alert.alert-secondary, .alert.alert-warning, .alert.alert-info, .alert.alert-dark, .page-header{
	background: #fef9c3!important;	
	border: 1px solid #fde68a!important;
}
.alert.alert-success.alert-with-border, .alert.alert-info.alert-with-border {
    border-left: 1px solid #000000!important;
}
.page-header h4{
	color: #000;
}
a:not(.active.list-group-item){
	border-color: #ffffff!important;
}
.table-bordered thead td, .table-bordered thead th{
	background: #fef9c3;
	color: #14532d;
	border-bottom:2px solid #eab308;
}
.table td, .table th {
    padding: 7px;
}

</style>

<!-- end::custom scripts -->
<script>
  $("#ascrail2005").scroll(function(){
  $("#ascrail2005").getNiceScroll().resize();
});

$(document).on('click', '.closebtn', function () {
  $(".openbtn").show();
  $(".closebtn").hide();
   closeNav();
  
});
$(document).on('click', '.openbtn', function () {
 
  $(".closebtn").show();
  $(".openbtn").hide();
   openNav();

});

function openNav() {
  // alert("dfkg");
  // document.getElementsByClassName("side-menu").style.width = "250px";
  $(".side-menu").attr("show");
  $(".side-menu").css("display", "block");
  $(".main-content").css("margin-left", "250px");
  $(".side-menu").css("opacity", "1");
 
 
  
}

function closeNav() {
  $(".side-menu").removeAttr("show");
  $(".side-menu").css("display", "none");
  $(".side-menu").css("opacity", "0");
  $(".main-content").css("margin-left", "0px");

  // document.getElementsByClassName("side-menu show").style.width = "0";
  
}


// Global empty-state for every DataTable grid/report: show "No records found" when no rows.
function applyDataTableEmptyDefaults() {
  try {
    if (window.jQuery && $.fn && $.fn.dataTable && $.fn.dataTable.defaults) {
      $.extend(true, $.fn.dataTable.defaults, {
        language: {
          emptyTable: "No records found",
          zeroRecords: "No records found",
          infoEmpty: "No records found"
        }
      });
    }
  } catch (e) { /* keep default DataTables text if extension fails */ }
}
applyDataTableEmptyDefaults();
$(function () { applyDataTableEmptyDefaults(); });


</script>