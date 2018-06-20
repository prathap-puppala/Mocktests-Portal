//This function is to load pages
function load_page(pat)
{
$("#pag_load").html("<br><br><center><img src='myown/img/loading.gif'></center><br><br>").load(pat);
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

//function to change settings
function changeset(sett,newv)
{
if(sett!=undefined && sett!='' && (newv=='yes' || newv=='no'))
{
$.post("logic/php/admin/changesettings.php",{sett:sett,newv:newv},function(data){if(data.indexOf("success")!=-1){alert("Successfully Updated!");location.reload();}});
} 	
}


//function to show user details
function shwuser()
{
var uid=document.getElementById("uid").value;
if(uid!=undefined && uid!="")
{
$("#aftrser").html("<br><br><br><br><center><img src='myown/img/loading8.gif'></center>");
$.post("logic/php/admin/shwuser.php",{uid:uid},function(data){$("#aftrser").html(data);});
}
else
{
return false;
}	
}


//function to change user state
function changeuserstate(uid)
{
var state=$("#usta").val();
if(state!=undefined && uid!='')
{
$.post("logic/php/admin/changeuserstate.php",{state:state,uid:uid},function(data){if(data.indexOf("success")!=-1){alert("Successfully Updated!");}});
} 	
}

//function for showing types of new exam
function shwf(fid)
{
$("#subp").show().html("<br><br><center>Loading........</center>").load("views/admin/"+fid+"-exam.php");	
}

function shwfor(fid)
{
$("#subp").show().html("<br><br><center>Loading........</center>").load("views/admin/"+fid+".php");	
}

//function to delete exam
function deleteexam(sno,mode)
{
$("#asd"+sno).html("<img src='myown/img/loading8.gif'>");	
if(confirm("Are you sure to delete?")){
	$.post("logic/php/admin/deleteexam.php",{sno:sno,mode:mode},function(data){if(data.indexOf("success")!=-1){$("#qwe"+sno).slideUp();}else{alert(data);}});
}
}

//function for showing options
function shwopt(opt,sid)
{
$("#uid").html(sid+" Options");
var n=new Array();
n=opt.split("~");
var cur=0;
var str="<table  class='table display' width='50%'><tr><td>";
for(var i=0;i<n.length;i++)
{
cur++;
str=str+"<mark>Que "+(i+1)+"</mark>&nbsp;&nbsp;&nbsp;&nbsp;<b>"+n[i]+"</b></td></tr><tr><td>";
}
str=str+"</tr></table>";

$("#opt").html(str);	
}

//function for removing exam
function rm(sid,sno)
{
$("#asd"+sid).html("<img src='myown/img/loading8.gif'>");	
if(confirm("Are you sure to delete?")){
	$.post("logic/php/admin/deleteuserexam.php",{sid:sid,sno:sno},function(data){if(data.indexOf("success")!=-1){$("#qwe"+sid).slideUp();}else{alert(data);}});
}

}

function rem(sid,sno,ni)
{
$("#asd"+ni).html("<img src='myown/img/loading8.gif'>");	
if(confirm("Are you sure to delete?")){
	$.post("logic/php/admin/deleteuserexam.php",{sid:sid,sno:sno},function(data){if(data.indexOf("success")!=-1){$("#qwe"+ni).slideUp();alert("Deleted");}else{alert(data);}});
}

}



//function for revalidatind exam
function re(sid,sno)
{
$("#asd"+sid).html("<img src='myown/img/loading8.gif'>");	
if(confirm("Are you sure to Revalidate?")){
	$.post("logic/php/admin/revalidateuserexam.php",{sid:sid,sno:sno},function(data){$("#qwe"+sid).html(data);});
}

}


//function for deleting exam
function del(sno)
{
$("#asd"+sno).html("<img src='myown/img/loading8.gif'>");	
if(confirm("Are you sure to delete?")){
	$.post("logic/php/admin/deletenotice.php",{sno:sno},function(data){if(data.indexOf("success")!=-1){$("#qwe"+sno).slideUp();}else{alert(data);}});
}

}
