//This function is to load pages
function load_page(pat)
{
$("#pag_load").html("<br><br><center><img src='myown/img/loading.gif'><br></center><br><br>").load(pat);
$("html,body").animate({scrollTop:0},600);
}

//This function is to hidden automatically
function hideleftnav()
{
	if($('.sidebar').hasClass('hidden')){
            $('.sidebar').removeClass('hidden');
            $('.content').css({
                'marginLeft' : 250
            });  
        }else{
            $('.sidebar').addClass('hidden');
            $('.content').css({
                'marginLeft' : 0
            });    
        }
	}

//function for show settings
function shwsettings()
{
 $(".sidepanel").toggle(100);	
}

function startexam(sno)
{
Lobibox.confirm({
                    msg: "Are you sure to start exam?",
                    title:"Confirmation",
                    iconClass:"fa fa-question",
                    callback: function ($this, type, ev) {
                        if (type === 'yes') {
					   swal("Starting...", "Please Wait....Exam is Loading...");
					    window.location="startexam-sub.php?sno="+sno; 
					   
                        } 
                    }
                });
}

function shwno(nid)
{
$("#opt").html("<br><img src='myown/img/loading8.gif'>");
$.post("views/user/viewnotice.php",{nid:nid},function(data){$("#opt").html(data);})	
}


//function for revalidatind exam
function re(sid,sno)
{
$("#asd"+sid).html("<img src='myown/img/loading8.gif'>");	
if(confirm("Are you sure to Revalidate?")){
	load_page("views/user/results.php");
}

}

//function for website rating
function dorating(cat)
{
$("#ratel").html("<img src='myown/img/loading8.gif'>");	
$.post("logic/php/user/dorating.php",{cat:cat},function(data){if(data.indexOf("success")!=-1){$('#rating').html("<center>Loading..</center>").load('rating.php');}else{alert(data);}});

}



