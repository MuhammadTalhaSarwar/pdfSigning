<?php
  ob_start(); 
  @set_time_limit(0);
  session_start();
  include("includes/config.php");
  include("security.php");
  include("includes/validate.php");
  include("includes/functions.php");
  include("includes/reader.php");
  include("SMSCounter.php");
  $menu=array('Menu','Back','API','Input','End');
$keypad =array('1','2','3','4','5','6','7','8','9','0','*','#');
$langArr=array('Multi-Language');
$admin_id=$_SESSION['custid'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<link href="style/css.css" rel="stylesheet" type="text/css" />

<?php include("ussdHead.php");?>
<!-- <link rel="stylesheet" href="css/pie/bootsrap.css" > -->
<script src="css/pie/jquery.js"></script>
<script src="css/pie/boostrap.js" ></script>
<script src="css/pie/licensedgo.js"></script>
<!--<script type="text/javascript" src="css/pie/oldgojs.js"></script>-->
<style type="text/css">
  .has-error input {
      border-color: #a94442;
      -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
      box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
  }
  .has-error textarea {
      border-color: #a94442;
      -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
      box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
  }
  .has-error{
    border-color: #a94442;
      -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
      box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
  }

  .has-success input {
      border-color: green;
      -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
      box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
  }
  .has-success textarea {
      border-color: green;
      -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
      box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
  }
  .has-success{
    border-color: green;
      -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
      box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
  }
  #myDiagramDiv
  {
  flex-grow: 1; height: 750px; background-color:white;
    }

  #addNew
  {
    position: relative;bottom: 5px;cursor: pointer;
  }
  #delNew
  {
    cursor: pointer;
  }
  #keypaddiv > div {
    float: left;
}
.controls-row
{
  margin: 0 !important;
}

</style>
</head>

<body>

<div class="mainwrapper">
    
    <!--<div id="preloader">
        <div id="status"> <img src="images/ajax_loader_big.gif"> <p class="txt">Loading... Please wait</p></div>
    </div>-->
    
    <?php include("header.php");?>
    
    <?php include("left_sidebar.php");?>
    
    <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="home.html"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li>USSD Studio</li>
            
        </ul>
        
        <div class="pageheader">
          <div class="pageicon"><span class="iconfa-pencil"></span></div>
            <div class="pagetitle">
                <h1 id="title">USSD Studio</h1>
            </div>
        </div>
        <div class="maincontent">
            <div class="maincontentinner">
              <div hidden="" class="alert alert-error " id="error_div" align="center"></div>
               <div class="">
                <!--<h4 class="widgettitle" id="headerUssd">USSD Menu Creation Form</h4>-->
                <div class="">
                <form class="stdform stdform2" action="" method="post" name="form1" id="form1" autocomplete="off">
                  <p>
                     <label>Name</label>
                       <span class="field">
                          <input name="menuName" class="input-large" id="menuNameInput" type="text" />
                        <span id="menInErr" class="form_error"><??></span>
                       </span>
                    </p>
                    <p hidden="">
                      <label>Creation Type</label>
                        <input type="radio" name="menuType" class="input-large creationType" value="Manual"/>Form
                         <input type="radio" name="menuType" class="input-large creationType" value="Graph" checked="" />Graph

                    </p>
                    <div class="clr"></div>
                    <div class="clr"></div>
                    <div class="clr"></div>
                    <div class="clr"></div>
                    <div class="clr"></div>
                    <div class="clr"></div>
                    <div class="clr"></div>

                    

                </form>
             <p id="graphP">
              <div id="myDiv" onload="init()">

  <div style=" display: flex; justify-content: space-between">
  <div id="newBtnDiv" class="myPaletteDiv2" style="position:relative;left: 10px;width: 8%; min-width: 90px;">
    <!--<div class="myPaletteDiv2"></div>-->
    <button id="createNew" class="btn btn-danger">New Node</button>
    <button id="saveMenu" class="btn btn-danger">Save</button>
    <button hidden="" id="editMenu" class="btn btn-danger">Save</button>
    </div>
  </div>
  <div id="myDiagramDiv"></div>
   </div>
 
  
  <div hidden="">
    <div >
      <button id="SaveButton" onclick="save()">Save</button>
      <button onclick="load()">Load</button>
      <button id="SaveButton" onclick="save()">Save It</button>
      <button id="backEndSave">Save Backend</button>
      Diagram Model saved in JSON format:
    </div>

    <textarea id="mySavedModel" style="width:100%;height:250px" hidden="">
{ "class": "go.GraphLinksModel",
  "copiesArrays": true,
  "copiesArrayObjects": true,
  "linkFromPortIdProperty": "fromPort",
  "linkToPortIdProperty": "toPort",
  "nodeDataArray": [
{"fill":"white","key":1,"selectedOptionDetails":"","name":"Menu Begin","loc":"2.271484375 -163","menuName": "","menuType": "Start","title":"Menu","descp":"","language":"",
 "bottomArray":[] }

 ],
  "linkDataArray": [
 ]}
    </textarea>
  </div>
  
</div>
<input type="text" id="selectedOptionType"/ hidden="">
<input type="text" id="selectedNodeId" hidden="" />
<input type="text" id="selectedMenuName" hidden="" />
<textarea name="selectedDesc" id="selectedDesc" cols="45" rows="5" style="width: 200px; height: 100px; overflow: hidden;white-space: pre-line" hidden=""></textarea>
<input style="display: none" type="text" id="selectedJump" hidden="" />
<input style="display: none" type="text" id="allowedChars" value="160" hidden="" />
<input style="display: none" type="text" id="selectedlanguage" hidden="" />
             </p>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<script id="code">
  var type="";
  var allowedEnglishCharacters="180";
  var allowedOtherCharacters="80";
  $(document).ready(function(){
    var url = window.location.href;
    var field = 'mid';
    if(url.indexOf('?' + field + '=') != -1)
    {
      type="edit";
      $('#headerUssd').text('USSD Studio');
          $('#title').text('USSD Studio');
      const urlParams = new URLSearchParams(window.location.search);
      const myParam = urlParams.get(field);
      $.ajax({
        url:'ussdMenu_backend.php',
        method:'GET',
        data:{menuId:myParam},
        success:function(res)
        {
          if(res!=false)
          {
          var parsedJson=JSON.parse(res);
          $('#menuNameInput').val(parsedJson[0]);
          $('#mySavedModel').val(parsedJson[1]);
          $('#saveMenu').hide();
          $('#editMenu').show();
          load();
        }
        else
        {
          window.location.href="ussd_menu_list.html";
        }
          //console.log(parsedJson[1]);

        }
      })
    }
    else
    {
      type="add";
      $('#editMenu').hide();
    }
    
    $('#mySavedModel').hide();
    $("#selectedOptionType").hide();
    $("#selectedNodeId").hide();
    $("#selectedMenuName").hide();
    $("#selectedDesc").hide();
    $("#selectedJump").hide();
    $('.creationType').on('click',function(e){
      if($(this).val()=='Graph')
      {
        $('#graphP').show();
        $('#myDiv').show();
      }
      else
      {
        $('#graphP').hide();
        $('#myDiv').hide();
      }
    })

  });
 var errorArr=[];
 var selectedKeys=new Array();
 var selectedTags=new Array();
 var oldKeys=new Array();
 var oldTags=new Array();
 var toBedeleted=new Array();

 function arr_diff (a1, a2) {

    var a = [], diff = [];

    for (var i = 0; i < a1.length; i++) {
        a[a1[i]] = true;
    }

    for (var i = 0; i < a2.length; i++) {
        if (a[a2[i]]) {
            delete a[a2[i]];
        } else {
            a[a2[i]] = true;
        }
    }

    for (var k in a) {
        diff.push(k);
    }

    return diff;
}
 function uuidv4() {
  return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
    var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
    return v.toString(16);
  });
}

  $(function(){
  $('#myDiv').trigger('onload');
});
function init() {
  function getFirst(array, n) {
      if (array == null) 
      return void 0;
    if (n == null) 
      return array[0];
    if (n < 0)
      return [];
    return array.slice(0, n);
  }
  var jumpNames=new Array();
  var options=new Array('Menu','Back','End');
      //if (window.goSamples) goSamples();  // init for these samples -- you don't need to call this
      var $$ = go.GraphObject.make;  //for conciseness in defining node templates
      function textStyle(field) {
        return [
          {
            font: "16px Roboto, Comic Sans MS Bold", stroke: "black",
            visible: false  // only show textblocks when there is corresponding data for them
          },
          new go.Binding("visible", field, function(val) { return val !== undefined; })
        ];
      }

      // define Converters to be used for Bindings
      function theNationFlagConverter(typeMEnu) {
        //return "https://www.nwoods.com/images/emojiflags/" + nation + ".png";
        if(typeMEnu=='Start')
        {
          return "css/pie/icon/icon-32x32-start.png";
        }
        else if(typeMEnu=='Menu')
        {
          return "css/pie/icon/icon-32x32-menu.png";
        }
        else if(typeMEnu=='Input')
        {
          return "css/pie/icon/icon-32x32-input.png";
        }
        else if(typeMEnu=='Back')
        {
          return "css/pie/icon/icon-32x32-back.png";
        }
        else if(typeMEnu=='End')
        {
          return "css/pie/icon/icon-32x32-end.png";
        }
        else if(typeMEnu=='Jump')
        {
          return "css/pie/ladder.png";
        }
        else if(typeMEnu=='API')
        {
          return "css/pie/icon/icon-32x32-api.png";
        }
        else
        {
          return "css/pie/icon/icon-32x32-alert.png";
        }
      }
      var mt8 = new go.Margin(8, 0, 0, 0);
      var mr8 = new go.Margin(0, 8, 0, 0);
      var ml8 = new go.Margin(0, 0, 0, 8);

      var roundedRectangleParams = {
        parameter1: 2,  // set the rounded corner
        spot1: go.Spot.TopLeft, spot2: go.Spot.BottomRight  // make content go all the way to inside edges of rounded corners
      };
      var pos="";
      if(type=="add")
      {
        pos=new go.Point(-600,0);
      }
      else
      {
        pos=new go.Point(-1200,0);
      }
      var myPalette2 =
    $(go.Palette, "myPaletteDiv2",
      { // customize the GridLayout to align the centers of the locationObjects
        layout: $$(go.GridLayout, { alignment: go.GridLayout.Location })
      });
      myDiagram =
        $$(go.Diagram, "myDiagramDiv",  //Diagram refers to its DIV HTML element by id{
        { 
            initialPosition:pos,
            initialAutoScale:go.Diagram.Uniform,
            isTreePathToChildren:true,
            initialContentAlignment:go.Spot.Center,
            //allowVerticalScroll:false,
          validCycle: go.Diagram.CycleAll,"undoManager.isEnabled": true,layout:  // create a TreeLayout for the family tree
              $$(go.TreeLayout,
                { treeStyle: go.TreeLayout.StyleLayered,
                  arrangement: go.TreeLayout.ArrangementHorizontal,
                  //alignment:go.TreeLayout.AlignmentBus,
                  angle: 90,
                  layerSpacing: 100,
                  nodeSpacing:100,
                  // properties for the "last parents":
                  alternateAngle: 90,
                  alternateLayerSpacing: 35,
                  alternateAlignment: go.TreeLayout.AlignmentBus,
                  alternateNodeSpacing: 20
                  // properties for most of the tree:
                   }) }

          );

      
      myDiagram.addDiagramListener("Modified", function(e) {
        var button = document.getElementById("SaveButton");
        if (button) button.disabled = !myDiagram.isModified;
        var idx = document.title.indexOf("*");
        if (myDiagram.isModified) {
          if (idx < 0) document.title += "*";
        } else {
          if (idx >= 0) document.title = document.title.substr(0, idx);
        }
      });
      

      // To simplify this code we define a function for creating a context menu button:
      function makeButton(text, action, visiblePredicate) {
        return $$("ContextMenuButton",
          $$(go.TextBlock, text),
          { click: action },
          // don't bother with binding GraphObject.visible if there's no predicate
          visiblePredicate ? new go.Binding("visible", "", function(o, e) { return o.diagram ? visiblePredicate(o, e) : false; }).ofObject() : {});
      }

      myDiagram.addDiagramListener("ObjectDoubleClicked",function(ev){
        $('#endDescpId').hide();
        $("#inputParamsDiv").hide();
        $('.rowParam').not(':first').remove();
        $('#saveBtn').removeAttr('data-dismiss');
        $('#errorDiv').hide();
        $('.apiDiv').hide();
        $('#saveBtn').show();
        $('#langDiv').show();
        errorArr=new Array();
        $('.inputText').each(function(){
          $(this).parent().removeClass('has-success');
        });
        $('#mName').parent('div').removeClass('has-success');
        $('#urlName').parent('div').removeClass('has-success');
        $('#txtarea').parent('div').removeClass('has-success');
        $('#txtarea').parent('div').removeClass('has-error');
        $('#inputParamsId').parent('div').removeClass('has-success');
        $('#inputParamsId').parent('div').removeClass('has-error');
        $('#inputparamsValId').parent('div').removeClass('has-success');
        $('#inputparamsValId').parent('div').removeClass('has-error');
        $('#endDescpTxtArea').parent('div').removeClass('has-error');
        $('#endDescpTxtArea').parent('div').removeClass('has-success');
        var selectedNodeId=ev.subject.part.data.key;
        //console.log(selectedNodeId);
        $('#selectedNodeId').val(selectedNodeId);
        $("#myModal").modal({backdrop: 'static',
    keyboard: false});
        $('#saveBtn').hide();
        $('.jumpMenClass').remove();
      if(myDiagram.model.linkDataArray.length!=0)
      {
        //console.log(jumpNames);
        $('#noOpt').remove();
          var jumpOpt="";
          for(var j=0;j<myDiagram.model.linkDataArray.length;j++)
          {
          var n=myDiagram.findNodeForKey(myDiagram.model.linkDataArray[j]['from']);
          //console.log(n.data.name);
            if(jumpNames.indexOf(n.data.name)>-1)
            {
              jumpNames.splice(jumpNames.indexOf(n.data.name,1));
              //
            }
            
              jumpNames.push(n.data.name);
          }
          for(var j=0;j<jumpNames.length;j++)
          {
            
            jumpOpt+='<option class="jumpMenClass" value="'+jumpNames[j]+'">'+jumpNames[j]+'</option>';
            
          }

          $('#defaultJump').after(jumpOpt);

         

          
      }
      else
      {
        if($('#noOpt').length==0)
        {
        $('#defaultJump').after('<option id="noOpt" value="not found" selected="true">No Jump Node Found</option>');
        }
      }
      var ss= myDiagram.findNodeForKey($('#selectedNodeId').val());
        if(ss.data.menuType!="" && ss.data.menuType!='Start')
        {
          $('#selectedOptionType').val(ss.data.menuType);
          $("#optionList").val(ss.data.menuType);
          $('#saveBtn').show();
        }
        else
        {
          $('#saveBtn').hide();
        }
        if(ss.data.menuType=='API')
        {
          $("#langDiv").hide();
          $("#inputParamsDiv").hide();
          $('.apiDiv').show();
          $("#apiType").val(ss.data.apiMethod);
          $("#urlName").val(ss.data.apiUrl);
          var paramArr=ss.data.params.split(",");
          var paramValueArr=ss.data.paramsVal.split(",");
          $(".params").first().val(paramArr[0]);
          $(".paramsVal").first().val(paramValueArr[0]);
          $('.rowParam').not(':first').remove();
          var ele="";
          if(ss.data.ttlParams>1)
          {
          for(var i=1;i<ss.data.ttlParams;i++)
          {

            ele+="<div class=rowParam><input type=text placeholder='Enter Parameter Name' name=params value="+paramArr[i]+" class=params> &nbsp;&nbsp; <input type=text placeholder='Enter Parameter Value' name=paramsVal class=paramsVal value="+paramValueArr[i]+"> <img id=delNew src='css/pie/minus.png'></div>";
          }
          $(ele).insertAfter($(".rowParam").last());
          }
        }
        if(ss.data.menuType=='End')
        {
          //console.log(ss.data.language+" End Menu");
          if(ss.data.language!="English" && ss.data.language!="")
          {
            $("#lang_0").attr("checked",true);
            $("#allowedChars").val(allowedOtherCharacters);
            $("#selectedlanguage").val("Multi");
          }
          else if(ss.data.language.length=="0" || ss.data.language=="")
          {
            $("#allowedChars").val(allowedEnglishCharacters);
            $("#selectedlanguage").val("English");
          }
          else
          {
            $("#allowedChars").val(allowedEnglishCharacters);
            $("#selectedlanguage").val("English");
          }
          $("#spanId2").text($("#allowedChars").val()+" Characters Left");
          $('#endDescpId').show();
          var enddescp=ss.data.descp;
          var enddescpArr=enddescp.split("/n/");
          if(enddescpArr.length>0)
          {
          var enddc="";
          for(var i=0;i<enddescpArr.length;i++)
          {
            if(enddescpArr[i]!='' && enddescpArr[i]!="")
            {
            if(enddescpArr.indexOf(enddescpArr[i])!=enddescpArr.length-1)
            {
            enddc+=enddescpArr[i].trim()+"\n";
            }
            else
            {
            enddc+=enddescpArr[i].trim();
            }
            }
          }
          $('#endDescpTxtArea').val(enddc);
          var ac=enddc.length;      
            }
            else
            {
            $('#endDescpTxtArea').val(enddescp);
            var ac=enddescp.length; 
            }
            if(enddescp.length!=0)
            {
            $("#allowedChars").val(parseInt($("#allowedChars").val())-parseInt(ac));
            }
            else
            {
            $("#allowedChars").val(allowedEnglishCharacters); 
            }
            //alert(ac)
            $("#spanId2").text($("#allowedChars").val()+" Characters Left");
            $('#endDescpTxtArea').attr("placeholder", "Please Enter End Message...");
        }
        if(ss.data.menuType=='Input')
        {
          //console.log(ss.data.language+" Input Menu");
            if(ss.data.language!="English" && ss.data.language!="")
          {
            $("#lang_0").attr("checked",true);
            $("#allowedChars").val(allowedOtherCharacters);
            $("#selectedlanguage").val("Multi");
          }
          else if(ss.data.language.length=="0" || ss.data.language=="")
          {
            $("#allowedChars").val(allowedEnglishCharacters);
            $("#selectedlanguage").val("English");
          }
          else
          {
            $("#allowedChars").val(allowedEnglishCharacters);
            $("#selectedlanguage").val("English");
          }
          $('#textDiv').show();
          $('#txtarea').val(ss.data.InputMessage);
          $("#inputParamsDiv").show();
          $("#inputParamsId").val(ss.data.params);
          if(ss.data.InputMessage.length!=0)
            {
            $("#allowedChars").val(parseInt($("#allowedChars").val())-parseInt(ss.data.InputMessage.length));
            }
            else
            {
            $("#allowedChars").val(allowedEnglishCharacters); 
            }
        }
        $("#spanId").text($("#allowedChars").val()+" Characters Left");
        $("#mName").val(ss.data.menuName);
        
        if(ss.data.menuType=='Menu' || ss.data.menuType=='Start')
        {
          
        if(ss.data.language!="English" && ss.data.language!="")
          {
            $("#lang_0").attr("checked",true);
            $("#allowedChars").val(allowedOtherCharacters);
            $("#selectedlanguage").val("Multi");
          }
          else if(ss.data.language.length=="0" || ss.data.language=="")
          {
            $("#allowedChars").val(allowedEnglishCharacters);
            $("#selectedlanguage").val("English");
          }
          else
          {
            $("#allowedChars").val(allowedEnglishCharacters);
            $("#selectedlanguage").val("English");
          }
        if(ss.data.bottomArray.length>0)
        {
        $('#endDescpId').hide(); 
        $('#keypaddiv').show();
        $('#saveBtn').show();
        $('#lableDiv').show();
        $(".optDiv").show();
        $(".jumpMenu").hide();
        $('#optionList').val('Menu');
        $('#selectedOptionType').val('Menu');
        $('#mName').val(ss.data.menuName);
        //console.log(type);
        //HERE CODING
        var descp=ss.data.descp;
        var descpArr=descp.split("/n/");
        if(descpArr.length>0)
        {
        var dc="";
        for(var i=0;i<descpArr.length;i++)
        {
        if(descpArr.indexOf(descpArr[i])!=descpArr.length-1)
        {  
        if(descpArr[i]!="" && descpArr[i]!=" ")
        {
        dc+=descpArr[i].trim()+"\n";
        }
        }
        else
        {
        dc+=descpArr[i].trim();
        }
        }      
        $('#txtarea').val(dc);
        var ac=dc.length;
        }
        else
        {
        $("#txtarea").val(descp);
        var ac=descp.length;
        }
        //console.log($("#allowedChars").val());
        //console.log(ac);
        if(descp.length!=0)
            {

            $("#allowedChars").val(parseInt($("#allowedChars").val())-parseInt(ac));
            
            }
            else
            {
            $("#allowedChars").val(allowedEnglishCharacters); 
            }
            $("#spanId").text($("#allowedChars").val()+" Characters Left");
        oldKeys=new Array();
        oldTags=new Array();
        current=new Array();
        toBedeleted=new Array();
        if(ss.data.bottomArray.indexOf('empty')>-1)
        {
          ss.data.bottomArray.splice('empty');
        }
        for(var o=0;o<ss.data.bottomArray.length;o++)
        {
          if(ss.data.bottomArray[o]!="undefined" || typeof ss.data.bottomArray[0] !=undefined)
          {
          //current.push(ss.data.bottomArray[o]);
          $('.keypadCls').each(function(){
           if($(this).val()==ss.data.bottomArray[o].lable)
           {
            $(this).prop('checked',true);
            oldKeys.push(ss.data.bottomArray[o].lable);
            oldTags.push(ss.data.bottomArray[o].selectedAction);
            $(this).parent('div').next().children().val(ss.data.bottomArray[o].selectedAction);
           }
          });
          }
        }
        for(var k=0;k<current.length;k++)
        {
          $('.keypadCls').each(function(){
            if(current.indexOf($(this).val())<=0)
            {
              $(this).attr('checked',false);
            }
          })
        }

        
        }
      }
      else if(ss.data.menuType=='Back')
      {
        $('#langDiv').hide();
      }
    });

      /*$('#optionList').on('change',function(){
        $('#selectedOptionType').val($(this).val());
        //alert($('#selectedOptionType').val());
        $('#langDiv').show();
        if($(this).val()=='Menu'){
        $("#endDescpId").hide();
        $("#inputParamsDiv").hide();
        $('#keypaddiv').show();
        $('#saveBtn').show();
        $('.optDiv').show();
        $('#lableDiv').show();
        $(".jumpMenu").hide();
        $('.apiDiv').hide();
        $('#txtarea').removeAttr("placeholder");

        }
        else if($(this).val()=='API')
        {
          $("#endDescpId").hide();
          $("#inputParamsDiv").hide();
          $('#saveBtn').show();
          $('.optDiv').hide();//HERE API
          $('.apiDiv').show();
          $('#keypaddiv').hide();
          $(".jumpMenu").hide();
          $('#langDiv').hide();

        }
        else if($(this).val()=='Back')
        {
          //alert("ok");
          $("#endDescpId").hide();
          $('.optDiv').hide();//HERE Input
          $('.apiDiv').hide();
          $('#keypaddiv').hide();
          $(".jumpMenu").hide();
          $('#textDiv').hide();
          $('#langDiv').hide();
        }
        else if($(this).val()=='Input')
        {
          $('#endDescpId').hide();
          $("#inputParamsDiv").show();
          $('#saveBtn').show();
          $('.optDiv').hide();//HERE Input
          $('.apiDiv').hide();
          $('#keypaddiv').hide();
          $(".jumpMenu").hide();
          $('#textDiv').show();
          if($("#txtarea").val()=="")
          {
          $('#txtarea').attr("placeholder", "Please Enter Input Description...");
          }
        }
        else if($(this).val()=='Jump')
        {
          if($('#selectedNodeId').val()!='1')
          {
          $(".jumpMenu").show();
          $('#saveBtn').show();
          $('#keypaddiv').hide();
          $('#saveBtn').show();
          $('.optDiv').hide();
          $('#lableDiv').hide();
          $('.apiDiv').hide();
          $('#selectedMenuName').val($('#mName').val());
          var s=myDiagram.findNodeForKey($('#selectedNodeId').val());
          myDiagram.model.setDataProperty(s.data,"name",$('#selectedMenuName').val());
          myDiagram.model.setDataProperty(s.data,"menuType","Jump");
          myDiagram.model.setDataProperty(s.data,"title","Jump");
          myDiagram.model.setDataProperty(s.data,"menuName",$('#selectedMenuName').val());
          myDiagram.model.setDataProperty(s.data,"descp",'Jump To '+$('#selectedJump').val());
           }
           else
           {
            alert("Can't Select Jump Option On Starting Node");
           }
         
        }
        else if($(this).val()=='End')
        {
        $(".jumpMenu").hide();
        $('#keypaddiv').hide();
        $('#saveBtn').show();
        $('.optDiv').hide();
        $('.apiDiv').hide();
        $('#lableDiv').hide();
        $("#inputParamsDiv").hide();
        $("#endDescpId").show();
        $('#endDescpTxtArea').attr("placeholder", "Please Enter End Message...");
        }
       });*/
       //new code changes
       $('#optionList').on('change',function(){
     
        $('#selectedOptionType').val($('#optionList :selected').val());
        $('#langDiv').show();
        if($('#selectedOptionType').val()=='Menu'){
        $("#endDescpId").hide();
        $("#inputParamsDiv").hide();
        $('#keypaddiv').show();
        $('#saveBtn').show();
        $('.optDiv').show();
        $('#lableDiv').show();
        $(".jumpMenu").hide();
        $('.apiDiv').hide();
        $('#txtarea').show();
        $('#spanId').show();
        $('#keypaddiv').show();
        $('#txtarea').removeAttr("placeholder");
        if($("#txtarea").val()=="")
          {
            if($("#lang_0").attr('checked'))
            {
              $('#spanId').text(allowedOtherCharacters +" Charcters Left");
            }
            else
            {
              $('#spanId').text(allowedEnglishCharacters +" Charcters Left");
            }
          $('#txtarea').attr("placeholder", "Please Enter Input Description...");

          }

        }
        else if($('#selectedOptionType').val()=='API')
        {
          $("#endDescpId").hide();
          $("#inputParamsDiv").hide();
          $('#saveBtn').show();
          $('.optDiv').hide();//HERE API
          $('.apiDiv').show();
          $('#keypaddiv').hide();
          $(".jumpMenu").hide();
          $('#langDiv').hide();

        }
        else if($('#selectedOptionType').val()=='Back')
        {
          //alert("ok");
          $("#endDescpId").hide();
          $('.optDiv').hide();//HERE Input
          $('.apiDiv').hide();
          $('#keypaddiv').hide();
          $(".jumpMenu").hide();
          $('#textDiv').hide();
          $('#langDiv').hide();
        }
        else if($('#selectedOptionType').val()=='Input')
        {
          $('#endDescpId').hide();
          $("#inputParamsDiv").show();
          $('#saveBtn').show();
          $('.optDiv').hide();//HERE Input
          $('.apiDiv').hide();
          $('#keypaddiv').hide();
          $(".jumpMenu").hide();
          $('#textDiv').show();
          if($("#txtarea").val()=="")
          {
            if($("#lang_0").attr('checked'))
            {
              $('#spanId').text(allowedOtherCharacters +" Charcters Left");
            }
            else
            {
              $('#spanId').text(allowedEnglishCharacters +" Charcters Left");
            }
          $('#txtarea').attr("placeholder", "Please Enter Input Description...");

          }
        }
        
        else if($('#selectedOptionType').val()=='End')
        {
          
        $(".jumpMenu").hide();
        $('#keypaddiv').hide();
        $('#saveBtn').show();
        $('.optDiv').hide();
        $('.apiDiv').hide();
        $('#lableDiv').hide();
        $("#inputParamsDiv").hide();
        $("#endDescpId").show();
        $('#endDescpTxtArea').attr("placeholder", "Please Enter End Message...");
        if($("#endDescpTxtArea").val()=="")
          {
            if($("#lang_0").attr('checked'))
            {
              $('#spanId2').text(allowedOtherCharacters +" Characters Left");
            }
            else
            {
              $('#spanId2').text(allowedEnglishCharacters +" Characters Left");
            }

          }
        }
       });
       //end new changes
       if($('#selectedOptionType').val()=='Menu')
       {
       $('.keypadCls').on('click',function(){
       $('.keypadCls').each(function(){
        if($(this).prop('checked'))
        {
          $(this).attr('checked',true);
        }
        else
        {
         $(this).attr('checked',false); 
         $(this).parent('div').next().removeClass('has-error');
        }

     });
       });
       //alert("OKOK");
        }

      $('#mName').on('keypress',function(){
       if(errorArr.indexOf('mName')>-1)
       {
        errorArr.splice(errorArr.indexOf('mName'));
        $('#mName').parent('div').removeClass('has-error');
        $('#mName').parent('div').addClass('has-success');
       }
      });

      $('#urlName').on('keypress',function(){
       if(errorArr.indexOf('urlName')>-1)
       {
        errorArr.splice(errorArr.indexOf('urlName'));
        $('#urlName').parent('div').removeClass('has-error');
        $('#urlName').parent('div').addClass('has-success');
       }
      });

      $('#txtarea').on('keyup',function(){
        //console.log(errorArr);
        let allowContinue=true;
        $('#txtarea').removeAttr('maxlength');
        if($("#lang_0").attr("checked"))
        {
        var allowedChars=allowedOtherCharacters;
        }
        else
        {
        var allowedChars=allowedEnglishCharacters
        }
        if(allowedChars>this.value.length)
        {
        allowedChars=allowedChars-this.value.length;
        }
        else
        {
          allowedChars="0";
          errorArr.push('txtarea');
          allowContinue=false;
          $('#txtarea').attr('maxlength','0');
        }
        
        $("#spanId").text(allowedChars+" Characters Left");
        if(allowContinue==true)
        {
       if(errorArr.indexOf('txtarea')>-1)
       {
        errorArr.splice(errorArr.indexOf('txtarea'));
        $('#txtarea').parent('div').removeClass('has-error');
        $('#txtarea').parent('div').addClass('has-success');
       }
       }
       else
       {
        $('#txtarea').parent('div').removeClass('has-success');
        $("#txtarea").parent('div').addClass('has-error');
       }

      });
      $('#endDescpTxtArea').on('keyup',function(){
        //console.log(errorArr);
        let allowContinue=true;
        $('#endDescpTxtArea').removeAttr('maxlength');
        if($("#lang_0").attr("checked"))
        {
        var allowedChars=allowedOtherCharacters;
        }
        else
        {
        var allowedChars=allowedEnglishCharacters
        }
        if(allowedChars>this.value.length)
        {
        allowedChars=allowedChars-this.value.length;
        }
        else
        {
          allowedChars="0";
          errorArr.push('endDescpTxtArea');
          allowContinue=false;
          $('#endDescpTxtArea').attr('maxlength','0');
        }
         $("#spanId2").text(allowedChars+" Characters Left");
       if(allowContinue==true)
       {
       if(errorArr.indexOf('endDescpTxtArea')>-1)
       {
        errorArr.splice(errorArr.indexOf('endDescpTxtArea'));
        $('#endDescpTxtArea').parent('div').removeClass('has-error');
        $('#endDescpTxtArea').parent('div').addClass('has-success');
       }
      }
      });

      $('#inputParamsId').on('keypress',function(){
        errorArr.splice(errorArr.indexOf('inputParamsId'));
        $('#inputParamsId').parent('div').removeClass('has-error');
        $('#inputParamsId').parent('div').addClass('has-success');
      });

      $('#inputparamsValId').on('keypress',function(){
        errorArr.splice(errorArr.indexOf('inputparamsValId'));
        $('#inputparamsValId').parent('div').removeClass('has-error');
        $('#inputparamsValId').parent('div').addClass('has-success');
      });

      $('.inputText').on('keypress',function(){
        if(errorArr.includes($(this).prop('id')))
        {
        $('#'+$(this).prop('id')).parent().removeClass('has-error');
        $('#'+$(this).prop('id')).parent().addClass('has-success');
        const index = errorArr.indexOf($(this).attr('id'));
if (index > -1) {
  errorArr.splice(index, 1);
}
        }
        //console.log(errorArr);
      });

      $('#jumpOpt').on('change',function(e){
        
        $('#selectedJump').val($(this).val());
      });

      $('#saveBtn').on('click',function(e){//HERE NOW
        
        e.preventDefault();
    
        $('#selectedMenuName').val($('#mName').val());
        $('#selectedDesc').val($('#txtarea').val());
        if($('#mName').val()=="")
        {
          errorArr.push("mName");
          $("#mName").parent('div').addClass('has-error');
          if(errorArr.length>0)
        {
          $('#errorDiv').show(); 
        }
        }
        if($('#selectedOptionType').val()=='Back')
        {
          //alert("okok");
          //$("#endDescpId").hide();
          if($('#selectedNodeId').val()!='1')
          {
          if(errorArr.length==0)
          {
          var parentKeys=new Array();
          var sNode=myDiagram.findNodeForKey($('#selectedNodeId').val());
          
          for(var i=0;i<myDiagram.model.linkDataArray.length;i++)
          {
          if(myDiagram.model.linkDataArray[i]['to']==$('#selectedNodeId').val())
          {
            parentKeys.push(myDiagram.model.linkDataArray[i]['from']);

          }
          }
          for(var i=0;i<myDiagram.model.linkDataArray.length;i++)
          {
          if(myDiagram.model.linkDataArray[i]['to']==parentKeys[0])
          {
            var pKey=myDiagram.model.linkDataArray[i]['from'];

          }
          }

          if(parentKeys.length!=0)
          {
          myDiagram.model.setDataProperty(sNode.data,"name",$('#selectedMenuName').val());
          myDiagram.model.setDataProperty(sNode.data,"menuType","Back");
          myDiagram.model.setDataProperty(sNode.data,"title","Back");
          myDiagram.model.setDataProperty(sNode.data,"menuName",$('#selectedMenuName').val());
          myDiagram.model.setDataProperty(sNode.data,"backTo",pKey);
          var pnode=myDiagram.findNodeForKey(pKey);
          myDiagram.model.setDataProperty(sNode.data,"descp","Back To "+ pnode.data.name);
          }
          else
          {
            myDiagram.remove(sNode);
          }
          }
          else
          {
            //console.log(errorArr);
          }
          }
          else
          {
            alert("Can't Change Start Menu To Back Menu");
          }

          $('#ex2form')[0].reset();
        $('#saveBtn').attr('data-dismiss',"modal");
          
        }
        else if($('#selectedOptionType').val()=='API')
        {//WORKING HERE
          //$('#lableDiv').hide();
          $("#inputParamsDiv").hide();
          if($('#urlName').val()=="")
          {
            $("#urlName").parent('div').addClass('has-error');
            errorArr.push("urlName");
          }
          if(errorArr.length>0)
          {
            $("#errorDiv").show();
          }
          else
          {
            $("#errorDiv").hide();
            var paramArr=new Array();
            var paramValueArr=new Array();
          $(".params").each(function(){
            paramArr.push($(this).val());
          });
          $(".paramsVal").each(function(){
            paramValueArr.push($(this).val());
          });

          var s=myDiagram.findNodeForKey($('#selectedNodeId').val());
          myDiagram.model.setDataProperty(s.data,"bottomArray",new Array());  
          myDiagram.model.setDataProperty(s.data,"menuType","API");
          myDiagram.model.setDataProperty(s.data,"title",$('#urlName').val());
          myDiagram.model.setDataProperty(s.data,"name","API");
          myDiagram.model.setDataProperty(s.data,"menuName",$('#selectedMenuName').val());
          myDiagram.model.setDataProperty(s.data,"apiMethod",$('#apiType').val());
          myDiagram.model.setDataProperty(s.data,"apiUrl",$('#urlName').val());
          myDiagram.model.setDataProperty(s.data,"ttlParams",$('.rowParam').length);
          myDiagram.model.setDataProperty(s.data,"params",paramArr.join());
          myDiagram.model.setDataProperty(s.data,"paramsVal",paramValueArr.join());
         
          addPort("bottom","Success","success","#1fed56",new go.Size(54,20));
          addPort("bottom","Error","error","#f50c0c",new go.Size(35,20));
          
          $('#ex2form')[0].reset();
          $('#saveBtn').attr('data-dismiss',"modal");
          }
        }
        else if($('#selectedOptionType').val()=='Input')
        {
          //NOW HERE INPUT
          //$("#inputParamsDiv").show();
          if($('#txtarea').val()=="")
        {
          errorArr.push('txtarea');
          $("#txtarea").parent('div').addClass('has-error');
        }

        if($('#inputParamsId').val()=="")
        {
          errorArr.push('inputParamsId');
          $("#inputParamsId").parent('div').addClass('has-error');
        }
        if($('#inputparamsValId').val()=="")
        {
          errorArr.push('inputparamsValId');
          $("#inputparamsValId").parent('div').addClass('has-error');
        }
        if(errorArr.length>0)
          {
            $("#errorDiv").show();
          }
          else{
            //alert($('#inputparamsValId').val());
            $("#errorDiv").hide();
            var s=myDiagram.findNodeForKey($('#selectedNodeId').val());
          myDiagram.model.setDataProperty(s.data,"bottomArray",new Array());  
          myDiagram.model.setDataProperty(s.data,"menuType","Input");
          myDiagram.model.setDataProperty(s.data,"title",$('#urlName').val());
          myDiagram.model.setDataProperty(s.data,"name","Input");
          myDiagram.model.setDataProperty(s.data,"menuName",$('#selectedMenuName').val());
          myDiagram.model.setDataProperty(s.data,"InputMessage",$('#txtarea').val());
          myDiagram.model.setDataProperty(s.data,"params",$("#inputParamsId").val());
          myDiagram.model.setDataProperty(s.data,"language",$("#selectedlanguage").val());
          //addPort("bottom","Success","success","#1fed56",new go.Size(54,20));
          //myDiagram.model.setDataProperty(s.data,"paramsVal",$('#inputparamsValId').val())
          addPort("bottom","Success","success","#1fed56",new go.Size(54,20));
          //addPort("bottom","Error","error","#f50c0c",new go.Size(35,20));
          $('#ex2form')[0].reset();
          $('#saveBtn').attr('data-dismiss',"modal");
          }
        }
        else if($('#selectedOptionType').val()=='Jump')
        {
          var s=myDiagram.findNodeForKey($('#selectedNodeId').val());
          myDiagram.model.setDataProperty(s.data,"descp",'Jump To '+$('#selectedJump').val());
        }
        else if($('#selectedOptionType').val()=='End')
        {
         if($('#endDescpTxtArea').val()=="")
         {
         errorArr.push('endDescpTxtArea');
          $("#endDescpTxtArea").parent('div').addClass('has-error'); 
         }
          $("#inputParamsDiv").hide();
         
            let thisEndDisc=$('#endDescpTxtArea').val();
          var txtStaticMessage=checkDescription(thisEndDisc);
          var eNode=myDiagram.findNodeForKey($('#selectedNodeId').val());
          myDiagram.model.setDataProperty(eNode.data,"name",$('#selectedMenuName').val());
          myDiagram.model.setDataProperty(eNode.data,"menuType","End");
          myDiagram.model.setDataProperty(eNode.data,"title","End");
          myDiagram.model.setDataProperty(eNode.data,"menuName",$('#selectedMenuName').val());
          myDiagram.model.setDataProperty(eNode.data,"descp",txtStaticMessage);
          myDiagram.model.setDataProperty(eNode.data,"language",$("#selectedlanguage").val());
          myDiagram.model.setDataProperty(eNode.data,"bottomArray",new Array());
            $('#ex2form')[0].reset();
            $('#saveBtn').attr('data-dismiss',"modal");
             for(var k=0;k<myDiagram.model.linkDataArray.length;k++)
            {
              if(myDiagram.model.linkDataArray[k]['from']==$('#selectedNodeId').val())
              {
                myDiagram.model.removeLinkData(myDiagram.model.linkDataArray[k]);
              }
            }
            //alert("Can't Select End On Start Menu");
        
        }
        else if($('#selectedOptionType').val()=='Jump')
        {

        }
        else if($('#selectedOptionType').val()=='Menu')
        {
        if($('#txtarea').val()=="")
        {
          errorArr.push('txtarea');
          $("#txtarea").parent('div').addClass('has-error');
        }
        if(selectedKeys.length>0)
        {
          selectedKeys=new Array();
          selectedTags=new Array();
          toBedeleted=new Array();
        }
         
      $('.keypadCls').each(function(){
        if($(this).prop('checked')){
          selectedKeys.push($(this).val());
          toBedeleted.push($(this).val());
          if(oldKeys.indexOf($(this).val())>-1)
          {
            selectedKeys.splice(selectedKeys.indexOf($(this).val()));
            //selectedTags.splice(selectedKeys.indexOf($(this).val()));
          }

          // if($('#keypd_').val()!='')
          if($(this).parent('div').next().children().val()=='')
          {
            
            $(this).parent('div').next().addClass('has-error');
            //console.log($(this).parent('div').next().children().prop('id'));
            //errorArr.push($(this).parent('div').next().children().prop('id'));
          }
          else
          {
            selectedTags.push($(this).parent('div').next().children().val());
          }
          if(oldKeys.indexOf($(this).val())>-1)
          {
            //selectedKeys.splice(selectedKeys.indexOf($(this).val()));
            selectedTags.splice(selectedKeys.indexOf($(this).val()));
          }

        }       
      });
      //console.log("old keys");
      //console.log(oldKeys);
      //console.log("To Be");
      //console.log(toBedeleted);
      //console.log(errorArr);
      if(oldKeys.length>0 && (oldKeys.length!=toBedeleted.length || oldKeys.length==toBedeleted.length))
      {
        var deleteThisPort=arr_diff(toBedeleted,oldKeys);
        var portsTobeRemoved=new Array();
        for(var i=0;i<deleteThisPort.length;i++)
        {
          if(oldKeys.indexOf(deleteThisPort[i])>-1)
          {
            portsTobeRemoved.push(deleteThisPort[i]);
          }
        }
        var myNode=myDiagram.findNodeForKey($('#selectedNodeId').val());
        var bottomdata=myNode.data.bottomArray;
        bottomdata = bottomdata.filter(function (el) {
            return el != null;
          });
        
        for(var j=0;j<bottomdata.length;j++)
        {
        for(var i=0;i<portsTobeRemoved.length;i++)
        {
          if(bottomdata[j].lable==portsTobeRemoved[i])
          {
            var portId=bottomdata[bottomdata.indexOf(bottomdata[j])]['portId'];
            delete bottomdata[bottomdata.indexOf(bottomdata[j])];
            //myDiagram.model.removeLinkData(myDiagram.model.linkDataArray[j]);
            bottomdata = bottomdata.filter(function (el) {
            return el != null;
          });
            for(var k=0;k<myDiagram.model.linkDataArray.length;k++)
            {
              if(myDiagram.model.linkDataArray[k]['from']==$('#selectedNodeId').val())
              {
                if(myDiagram.model.linkDataArray[k]['fromPort']==portId)
                {
                 myDiagram.model.removeLinkData(myDiagram.model.linkDataArray[k]);
                 break; 
                }
              }
            }
          }
        }
        }
        
        myDiagram.model.setDataProperty(myNode.data,'bottomArray',bottomdata);
      }

       if(errorArr.length>0)
        {
          $('#errorDiv').show(); 
          //console.log("HEREE");
        }
        else
        {
          //alert($("#selectedlanguage").val());
          $('#errorDiv').hide();
          myDiagram.commit(function(d) {
  d.nodes.each(function(node) {
    if(node.data.key==$('#selectedNodeId').val())
    {
      let thisDisc=$('#selectedDesc').val();
      var txtStaticMessage=checkDescription(thisDisc);
      //console.log("TXT "+txtStaticMessage);
      myDiagram.model.setDataProperty(node.data,"name",$('#selectedMenuName').val());
      
      myDiagram.model.setDataProperty(node.data,"menuType",$('#selectedOptionType').val());
      
      myDiagram.model.setDataProperty(node.data,"title",$('#selectedOptionType').val());
      myDiagram.model.setDataProperty(node.data,"menuName",$('#selectedMenuName').val());
      myDiagram.model.setDataProperty(node.data,"descp",txtStaticMessage);
      myDiagram.model.setDataProperty(node.data,"language",$("#selectedlanguage").val()); 
    }
  });

}, "decrease scale");
          for(var i=0;i<selectedKeys.length;i++)
          {           
            addPort("bottom",selectedKeys[i],selectedTags[i]);
          }
          //console.log(myDiagram.model);
      myDiagram.model=go.Model.fromJson(myDiagram.model);     
        }
        //console.log(errorArr.length);
        if(errorArr.length==0)
        {
        $('#ex2form')[0].reset();
        $('#saveBtn').attr('data-dismiss',"modal");
        $('#keypaddiv').hide();
        $('#saveBtn').hide();
        $('.optDiv').hide();
        $('#lableDiv').hide();

        $('.keypadCls').each(function(){
          if($(this).prop('checked')){
            $(this).removeAttr('checked');
          }
        });

        }
      }
      });//end saveBtn
  function checkDescription(descp)
  {
    var txtStaticMessage="";
      var splited=descp.split("\n");
      splited.forEach(function(ele){
        if(ele!="" && ele!=" ")
        {
        if(splited.indexOf(ele)!=splited.length-1)
        {
        txtStaticMessage+=ele.trim()+"/n/";
        }
        else
        {
        txtStaticMessage+=ele.trim()  
        }
        }

      });
      return txtStaticMessage;
  }
      function nodeStyle() {
        return [
          new go.Binding("location", "loc", go.Point.parse).makeTwoWay(go.Point.stringify),
          {
            // the Node.location is at the center of each node
            locationSpot: go.Spot.Center
          }
        ];
      }
      $('#close-me').on('click',function(e){
      selectedTags=new Array();
      selectedKeys=new Array();
      oldKeys     =new Array();
      oldTags     =new Array();
      $('.inputText').each(function(){
          $(this).parent('div').removeClass('has-success');
          $(this).parent('div').removeClass('has-error');
        });
      $('#keypaddiv').hide();
        $('#saveBtn').hide();
        $('.optDiv').hide();
        $('#lableDiv').hide();
        $(".jumpMenu").hide();
      $('#mName').parent('div').removeClass('has-success');
      $('#txtarea').parent('div').removeClass('has-success');
      $('#mName').parent('div').removeClass('has-error');
      $('#txtarea').parent('div').removeClass('has-error');
      $('#endDescpTxtArea').parent('div').removeClass('has-error');
      $('#endDescpTxtArea').parent('div').removeClass('has-success');

      $('#ex2form')[0].reset();
    });
       function mouseEnter(e, obj) {
    var shape = obj.findObject("SHAPE");
    shape.fill = "#6DAB80";
    shape.stroke = "#A6E6A1";
    var text = obj.findObject("TEXT");
    text.stroke = "white";
  };

  function mouseLeave(e, obj) {
    var shape = obj.findObject("SHAPE");
    // Return the Shape's fill and stroke to the defaults
    console.log(obj.data);
    shape.fill = '#913745';
    shape.stroke = null;
    // Return the TextBlock's stroke to its default
    var text = obj.findObject("TEXT");
    text.stroke = "black";
  };

      var nodeMenu =  // context menu for each Node
        $$("ContextMenu",
          /*makeButton("Copy",
            function(e, obj) { e.diagram.commandHandler.copySelection(); }),*/
          makeButton("Delete",
            function(e, obj) {
               var nodeTobeDeleted=myDiagram.selection.iterator.first().data.key;
              if(nodeTobeDeleted==1)
              {
                alert("You Are Trying To Delete The Start Node.Kindly Make A New Start Node After Deleting The Old One");
                $('#createNew').text("Start Node");
              }  
              e.diagram.commandHandler.deleteSelection(); }),
          /*$$(go.Shape, "LineH", { strokeWidth: 2, height: 1, stretch: go.GraphObject.Horizontal }),
          makeButton("Add top port",
            function(e, obj) { addPort("top"); }),
          makeButton("Add left port",
            function(e, obj) { addPort("left"); }),
          makeButton("Add right port",
            function(e, obj) { addPort("right"); }),
          makeButton("Add bottom port",
            function(e, obj) { addPort("bottom"); })*/
        );

      var portSize = new go.Size(16, 16);

      var portMenu =  // context menu for each port
        $$("ContextMenu",
          makeButton("Swap order",
            function(e, obj) { swapOrder(obj.part.adornedObject); }),
          makeButton("Remove port",
            // in the click event handler, the obj.part is the Adornment;
            // its adornedObject is the port
            function(e, obj) { removePort(obj.part.adornedObject); }),
          makeButton("Change color",
            function(e, obj) { changeColor(obj.part.adornedObject); }),
          makeButton("Remove side ports",
            function(e, obj) { removeAll(obj.part.adornedObject); })
        );

      // the node template
      // includes a panel on each side with an itemArray of panels containing ports
      myDiagram.grid.visible = true;
      myDiagram.grid.gridCellSize = new go.Size(30, 20);
      myDiagram.toolManager.draggingTool.isGridSnapEnabled = true;
      myDiagram.toolManager.resizingTool.isGridSnapEnabled = true;
      myDiagram.nodeTemplate =
        $$(go.Node, "Auto",new go.Binding("location", "loc", go.Point.parse),

          {

            //mouseEnter: mouseEnter,
            //mouseLeave: mouseLeave,
            locationSpot: go.Spot.TopCenter,
            isShadowed: true, shadowBlur: 1,
            shadowOffset: new go.Point(0, 1),
            shadowColor: "rgba(0, 0, 0, .14)",
            locationObjectName: "BODY",
            selectionObjectName: "BODY",
            contextMenu: nodeMenu,
            selectionAdornmentTemplate:  // selection adornment to match shape of nodes
              $$(go.Adornment, "Auto",
                $$(go.Shape, "RoundedRectangle", roundedRectangleParams,
                  { fill: null, stroke: "#831A2B", strokeWidth: 3 }
                ),
                $$(go.Placeholder)
              )  
          },
          //$$(go.Shape,"Rectangle",{fill:null,stroke:"black",strokeWidth:3}),
          $$(go.Panel,"Auto",
          $$(go.Panel,"Vertical",
            //$$(go.Shape,"Rectangle",{fill:null,stroke:"black",strokeWidth:3}),
          $$(go.Panel, "Horizontal",
            new go.Binding("itemArray", "topArray"),
            {
              row: 2, column: 1,
              itemTemplate:
                $$(go.Panel,"Spot",{alignment: go.Spot.TopRight, alignmentFocus: go.Spot.TopRight},
                $$(go.Panel,
                  {
                    _side: "top",

                    fromSpot: go.Spot.Top, toSpot: go.Spot.Top,
                    fromLinkable: true, toLinkable: true, cursor: "pointer",
                    contextMenu: portMenu
                  },
                  new go.Binding("portId", "portId"),
                  
                  $$(go.Shape, "RoundedRectangle",
                    {
                      stroke: null, strokeWidth: 3,
                      desiredSize: portSize,
                      margin: new go.Margin(0, 1),
                      fromLinkableDuplicates: true, toLinkableDuplicates: true,

                    },
                    new go.Binding("fill", "portColor"))
                )  // end itemTemplate
                )
            }
          )
          )
          ),

          $$(go.Panel,'Auto',
            //{background: "lightgray"},
          $$(go.Shape, "RoundedRectangle", { 
            minSize: new go.Size(160,NaN),
            fill: "#cce6ff", // the default fill, if there is no data-binding
                stroke: "black",
                //height: 40,
                strokeWidth: 1,
                cursor: "pointer", 
          },
          new go.Binding("fill", "fill")
            //{name: "SHAPE", fill: "green", strokeWidth: 1 },
            // bluish if highlighted, white otherwise
            //new go.Binding("fill", "isHighlighted", function(h,obj) { return h ? "#e8eaf6" : "#f7867e"; }).ofObject()
          ),
          
          $$(go.Panel, "Vertical",
            $$(go.Panel, "Horizontal",
              
            { margin: 8 },
            $$(go.Picture,  
                { margin: mr8, visible: false, desiredSize: new go.Size(50, 50) },
                new go.Binding("source", "menuType", theNationFlagConverter),
                new go.Binding("visible", "menuType", function(nat) { return nat !== undefined; }),
              ),

              $$(go.Panel, "Table",
                $$(go.TextBlock,
                  {
                    row: 0, alignment: go.Spot.Left,
                    font: "16px Roboto, Comic Sans MS Bold",
                    stroke: "rgba(0, 0, 0, .87)",
                    maxSize: new go.Size(160, NaN)
                  },
                  new go.Binding("text", "name")
                ),
                $$(go.TextBlock, textStyle("title"),
                  {
                    row: 1, alignment: go.Spot.Left,
                    maxSize: new go.Size(160, NaN)
                  },
                  new go.Binding("text", "title")
                ),
                $$("PanelExpanderButton", "INFO",
                  { row: 0, column: 1, rowSpan: 2, margin: ml8 }
                )
              )),//Horizontal Panel  
            $$(go.Shape, "LineH",
              {
                stroke: "rgba(0, 0, 0, .60)", strokeWidth: 1,
                height: 1, stretch: go.GraphObject.Horizontal
              },
              new go.Binding("visible").ofObject("INFO")  // only visible when info is expanded
            ),
            $$(go.Panel,"Table",

            $$(go.Panel, "Vertical",
              {
                name: "INFO",  // identify to the PanelExpanderButton
                stretch: go.GraphObject.Horizontal,  // take up whole available width
                margin: 8,
                defaultAlignment: go.Spot.Left,  // thus no need to specify alignment on each element
              },
              $$(go.TextBlock,textStyle("name"),
                new go.Binding("text", "menuName", function(name) { return name ; })
              ),
              $$(go.TextBlock, textStyle("descp"),
                new go.Binding("margin", "name", function(head) { return mt8; }), // some space above if there is also a headOf value
                new go.Binding("text", "descp", function(descp) {
                  //console.log(descp);
                  var boss = myDiagram.model.findNodeDataForKey(descp);
                  //var txtStaticMessage=checkDescription(thisDisc);
                  descpArr=descp.split("/n/");
                  var dc="";
                  for(var i=0;i<descpArr.length;i++)
                  {
                    if(i!=descpArr.length-1)
                    {
                    dc+=descpArr[i]+".";
                    }
                    else
                    {
                    dc+=descpArr[i]
                    }
                  }
                  //console.log(dc);
                  return dc;
                  
                })
              )
            )),
            $$(go.Panel,"Auto",
            $$(go.Panel, "Horizontal",
            new go.Binding("itemArray", "bottomArray"),

            {
              row: 2, column: 1,
              itemTemplate:
                $$(go.Panel,
                  {
                    _side: "bottom",
                    fromSpot: go.Spot.Bottom, toSpot: go.Spot.Bottom,
                    fromLinkable: true, toLinkable: true, cursor: "pointer",
                    contextMenu: portMenu
                  },
                  new go.Binding("portId", "portId"),
                  $$(go.Shape, "RoundedRectangle",
                    {
                      stroke: null, strokeWidth: 0,
                      desiredSize: portSize,
                      margin: new go.Margin(0, 5)
                    },
                    new go.Binding("desiredSize","portSize"),
                    new go.Binding("fill", "portColor")),
                  $$(go.TextBlock, {font: "14px Roboto, Comic Sans MS Bold", margin: new go.Margin(0,10),alignment:go.Spot.Center},
                new go.Binding("text", "lable"))
                )  // end itemTemplate
            }
          )),
          )//Vertical Panel
          ),
          
        );  // end Node

        myDiagram.linkTemplate =
    $$(go.Link,{routing: go.Link.AvoidsNodes,curve: go.Link.JumpGap,
reshapable: true,
resegmentable: true,corner: 10},
      $$(go.Shape,{stroke:"#831A2B",strokeWidth: 4}),
      $$(go.Shape, { toArrow: "Standard",stroke:"#831A2B",strokeWidth:4}),
      $$(go.Panel, "Auto",  // this whole Panel is a link label
        /*$$(go.Shape, "Rectangle", { fill: "yellow", stroke: "gray" }),
        $$(go.TextBlock, { margin: 3 },
          new go.Binding("text", "text"))*/
      )
    );

    

      myDiagram.contextMenu =
        $$("ContextMenu",
          makeButton("Paste",
            function(e, obj) { e.diagram.commandHandler.pasteSelection(e.diagram.toolManager.contextMenuTool.mouseDownPoint); },
            function(o) { return o.diagram.commandHandler.canPasteSelection(o.diagram.toolManager.contextMenuTool.mouseDownPoint); }),
          makeButton("Undo",
            function(e, obj) { e.diagram.commandHandler.undo(); },
            function(o) { return o.diagram.commandHandler.canUndo(); }),
          makeButton("Redo",
            function(e, obj) { e.diagram.commandHandler.redo(); },
            function(o) { return o.diagram.commandHandler.canRedo(); })
        );
      load();
      $('#createNew').on('click',function(e){
        if(myDiagram.findNodeForKey(1)==null && $('#createNew').text()=="Start Node")
        {
          myDiagram.model.nodeDataArray.push({"fill":"white","key":1,"selectedOptionDetails":"","name":"Menu Begin","loc":"2.271484375 -163","menuName": "","menuType": "Start","title":"Menu","descp":"","language":"",
 "bottomArray":[] });
          myDiagram.model=go.Model.fromJson(myDiagram.model);
          $(this).text("New Node");
          $("#ChangeDesc").val('');
        }
        else
        {
        $("#ChangeDesc").val('');
        var timestamp = new Date().getUTCMilliseconds();
            var opId='id_'+timestamp;
            var first=getFirst(selectedTags);
            //console.log(first);
            var uuid=uuidv4();
            //console.log(first);
            selectedTags.shift();
            var c='#'+Math.floor((Math.random()*222)+33).toString(16)+(Math.floor((Math.random()*222)+33).toString(16))+(Math.floor((Math.random()*222)+33).toString(16));
            var c="white";
            myDiagram.model.nodeDataArray.push({"fill":c,"key":uuid,"selectedOptionDetails":first,"name":"New Node","bottomArray":[],"topArray":[{portId:'top0',portColor:'black'}],menuName:"",menuType:"","title":"",descp:""});
              myDiagram.model=go.Model.fromJson(myDiagram.model);
        }
              
      });

      $('#backEndSave').on('click',function(e){
        var backEndJson=new Object({start:1});
        var allBackEndLinks=new Array();
        var backEndNodeData=myDiagram.model.nodeDataArray;
        var backEndLink=myDiagram.model.linkDataArray;
        var keysToWatch=new Array();
        //console.log(backEndNodeData);
        //console.log("LINKSSS");
        //console.log(backEndLink);
        for(var i=0;i<backEndLink.length;i++)
        {
          allBackEndLinks.push(backEndLink[i]['from']);
        }
        for(var i=0;i<backEndNodeData.length;i++)
        {
        if(allBackEndLinks.indexOf(backEndNodeData[i]['key'])>-1)
        {
          backEndJson[backEndNodeData[i]['key']]=new Object();
          backEndJson[backEndNodeData[i]['key']]['options']=new Object();
        }
        }
        //console.log(Object.keys(backEndJson));
      });
    }

    function CustomLink() {
      go.Link.call(this);
    };
    go.Diagram.inherit(CustomLink, go.Link);

    CustomLink.prototype.findSidePortIndexAndCount = function(node, port) {
      var nodedata = node.data;
      if (nodedata !== null) {
        var portdata = port.data;
        var side = port._side;
        var arr = nodedata[side + "Array"];
        var len = arr.length;
        for (var i = 0; i < len; i++) {
          if (arr[i] === portdata) return [i, len];
        }
      }
      return [-1, len];
    };

    CustomLink.prototype.computeEndSegmentLength = function(node, port, spot, from) {
      var esl = go.Link.prototype.computeEndSegmentLength.call(this, node, port, spot, from);
      var other = this.getOtherPort(port);
      if (port !== null && other !== null) {
        var thispt = port.getDocumentPoint(this.computeSpot(from));
        var otherpt = other.getDocumentPoint(this.computeSpot(!from));
        if (Math.abs(thispt.x - otherpt.x) > 20 || Math.abs(thispt.y - otherpt.y) > 20) {
          var info = this.findSidePortIndexAndCount(node, port);
          var idx = info[0];
          var count = info[1];
          if (port._side == "top" || port._side == "bottom") {
            if (otherpt.x < thispt.x) {
              return esl + 4 + idx * 8;
            } else {
              return esl + (count - idx - 1) * 8;
            }
          } else {  // left or right
            if (otherpt.y < thispt.y) {
              return esl + 4 + idx * 8;
            } else {
              return esl + (count - idx - 1) * 8;
            }
          }
        }
      }
      return esl;
    };

    CustomLink.prototype.hasCurviness = function() {
      if (isNaN(this.curviness)) return true;
      return go.Link.prototype.hasCurviness.call(this);
    };

    CustomLink.prototype.computeCurviness = function() {
      if (isNaN(this.curviness)) {
        var fromnode = this.fromNode;
        var fromport = this.fromPort;
        var fromspot = this.computeSpot(true);
        var frompt = fromport.getDocumentPoint(fromspot);
        var tonode = this.toNode;
        var toport = this.toPort;
        var tospot = this.computeSpot(false);
        var topt = toport.getDocumentPoint(tospot);
        if (Math.abs(frompt.x - topt.x) > 20 || Math.abs(frompt.y - topt.y) > 20) {
          if ((fromspot.equals(go.Spot.Left) || fromspot.equals(go.Spot.Right)) &&
            (tospot.equals(go.Spot.Left) || tospot.equals(go.Spot.Right))) {
            var fromseglen = this.computeEndSegmentLength(fromnode, fromport, fromspot, true);
            var toseglen = this.computeEndSegmentLength(tonode, toport, tospot, false);
            var c = (fromseglen - toseglen) / 2;
            if (frompt.x + fromseglen >= topt.x - toseglen) {
              if (frompt.y < topt.y) return c;
              if (frompt.y > topt.y) return -c;
            }
          } else if ((fromspot.equals(go.Spot.Top) || fromspot.equals(go.Spot.Bottom)) &&
            (tospot.equals(go.Spot.Top) || tospot.equals(go.Spot.Bottom))) {
            var fromseglen = this.computeEndSegmentLength(fromnode, fromport, fromspot, true);
            var toseglen = this.computeEndSegmentLength(tonode, toport, tospot, false);
            var c = (fromseglen - toseglen) / 2;
            if (frompt.x + fromseglen >= topt.x - toseglen) {
              if (frompt.y < topt.y) return c;
              if (frompt.y > topt.y) return -c;
            }
          }
        }
      }
      return go.Link.prototype.computeCurviness.call(this);
    };
    


    
    function addPort(side,label="",opt="",pc="",pz=new go.Size(16,16)) {
      myDiagram.startTransaction("addPort");
      myDiagram.selection.each(function(node) {
        if (!(node instanceof go.Node)) return;
        var i = 0;
        while (node.findPort(side + i.toString()) !== node) i++;
        var name = side + i.toString();
        var arr = node.data[side + "Array"];
        
        if (arr) {
          // create a new port data object
          if(pc.length==0)
          {
          var newportdata = {
            portId: name,
            lable:label,
            selectedAction:opt,
            portColor: getPortColor(),
            portSize:pz
           
          };
          }
          else
          {
            var newportdata = {
            portId: name,
            lable:label,
            selectedAction:opt,
            portColor: pc,
            portSize:pz,
           
          };
          }
         
          myDiagram.model.insertArrayItem(arr, -1, newportdata);
        }
      });
      myDiagram.commitTransaction("addPort");
    }

    function swapOrder(port) {
      var arr = port.panel.itemArray;
      if (arr.length >= 2) {  // only if there are at least two ports!
        for (var i = 0; i < arr.length; i++) {
          if (arr[i].portId === port.portId) {
            myDiagram.startTransaction("swap ports");
            if (i >= arr.length - 1) i--;  // now can swap I and I+1, even if it's the last port
            var newarr = arr.slice(0);  // copy Array
            newarr[i] = arr[i + 1];  // swap items
            newarr[i + 1] = arr[i];
            // remember the new Array in the model
            myDiagram.model.setDataProperty(port.part.data, port._side + "Array", newarr);
            myDiagram.commitTransaction("swap ports");
            break;
          }
        }
      }
    }

    function removePort(port) {
      myDiagram.startTransaction("removePort");
      var pid = port.portId;
      var arr = port.panel.itemArray;
      for (var i = 0; i < arr.length; i++) {
        if (arr[i].portId === pid) {
          myDiagram.model.removeArrayItem(arr, i);
          break;
        }
      }
      myDiagram.commitTransaction("removePort");
    }

    function removeAll(port) {
      myDiagram.startTransaction("removePorts");
      var nodedata = port.part.data;
      var side = port._side;  
      myDiagram.model.setDataProperty(nodedata, side + "Array", []);
      myDiagram.commitTransaction("removePorts");
    }

    
    function changeColor(port) {
      myDiagram.startTransaction("colorPort");
      var data = port.data;
      myDiagram.model.setDataProperty(data, "portColor", getPortColor());
      myDiagram.commitTransaction("colorPort");
    }

    
    function getPortColor() {
      var portColors = ["#fae3d7", "#d6effc", "#ebe3fc", "#eaeef8", "#fadfe5", "#6cafdb", "#66d6d1"]
      return portColors[Math.floor(Math.random() * portColors.length)];
    }

    function save() {
      alert("ok");
      document.getElementById("mySavedModel").value = myDiagram.model.toJson();
      myDiagram.isModified = false;
    }



    var error_backend=false;
    var admin_id=<?echo $admin_id;?>;
    $('#saveMenu').on('click',function(e){
      //console.log($('#menuNameInput').val());
      if($('#menuNameInput').val()=='')
      {
        error_backend=true;
        $('#menInErr').text('Please Enter Name First');
      }
      if(myDiagram.findNodeForKey(1)==null)
      {
        $('#menInErr').text('Start Node Is Missing.Please Create A Start Node First');
        error_backend=true;
      }
      if(error_backend==false)
      {
        // var blob = myDiagram.makeImageData({  background: "white",  details: 0.95});
        var svg = myDiagram.makeSvg({scale:0.7,background: "white" });
      var svgstr = new XMLSerializer().serializeToString(svg);
      // var blob = new Blob([svgstr], { type: "image/svg+xml" });
      var blob = JSON.stringify(svgstr);
      console.log(blob)
        // console.log(blob)
        //console.log(myDiagram.makeImageData());
        //new written

      $.ajax({
    url: 'saving_screenshot_ussd_menu.php',
    type: 'post',
    data: {image: blob,admin_id: admin_id,menu_name: $('#menuNameInput').val()},
    success: function(data){
       console.log('Upload successfully');
       var screenshot_name = JSON.parse(data);
       console.log(screenshot_name);
       $.ajax({
          url:"ussdMenu_backend.php",
          method:'POST',
          data:{menuname:$('#menuNameInput').val(),admin_id:admin_id,menuJson:myDiagram.model.toJson(), image_file_name: screenshot_name},
          success:function(response)
          {
            // console.log(response);
            // alert(response);
            //console.log(JSON.parse(response));
            if(JSON.parse(response)==true)
            {
              window.location.href="ussd_menu_list.html?message=Menu Added Successfully";
            }
            else if(JSON.parse(response)=="Already Exists")
            {
             error_backend=true;
             $('#error_div').show();
             $('#error_div').text('Please Fix The Following Error(s)');
            $('#menInErr').text('Menu With Similar Name Already Exists'); 
            }
            else
            {
              $('#error_div').show();
             $('#error_div').text('There Was Some Issue Saving The Menu.Please Try Again Later');
            }
          }
        });
      //  alert("SAVED");
    }
 });


        //previously written
     
        // $.ajax({
        //   url:"ussdMenu_backend.php",
        //   method:'POST',
        //   data:{menuname:$('#menuNameInput').val(),admin_id:admin_id,menuJson:myDiagram.model.toJson()},
        //   success:function(response)
        //   {
        //     //console.log(JSON.parse(response));
        //     if(JSON.parse(response)==true)
        //     {
        //       window.location.href="ussd_menu_list.html?message=Menu Added Successfully";
        //     }
        //     else if(JSON.parse(response)=="Already Exists")
        //     {
        //      error_backend=true;
        //      $('#error_div').show();
        //      $('#error_div').text('Please Fix The Following Error(s)');
        //     $('#menInErr').text('Menu With Similar Name Already Exists'); 
        //     }
        //     else
        //     {
        //       $('#error_div').show();
        //      $('#error_div').text('There Was Some Issue Saving The Menu.Please Try Again Later');
        //     }
        //   }
        // });
      }

    });

    $('#editMenu').on('click',function(e){
      if($('#menuNameInput').val()=='')
      {
        error_backend=true;
        $('#menInErr').text('Please Enter Name First');
      }
       if(myDiagram.findNodeForKey(1)==null)
      {
        $('#menInErr').text('Start Node Is Missing.Please Create A Start Node First');
        error_backend=true;
      }
      if(error_backend==false)
      {
        const urlParams = new URLSearchParams(window.location.search);
        const myParam = urlParams.get('mid');
        var admin_id=<?echo $admin_id;?>;
        myDiagram.model.toJson();
//newwritten

var svg = myDiagram.makeSvg({scale:0.7,background: "white" });
      var svgstr = new XMLSerializer().serializeToString(svg);
      // var blob = new Blob([svgstr], { type: "image/svg+xml" });
      var blob = JSON.stringify(svgstr);
      console.log(blob)
    
// var edit_blob = myDiagram.makeImageData({ background: "white",  details: 0.95});

        // console.log(blob)
        //console.log(myDiagram.makeImageData());
        //new written

      $.ajax({
    url: 'saving_screenshot_ussd_menu.php',
    type: 'post',
    data: {image: blob,admin_id: admin_id,menu_name: $('#menuNameInput').val()},
    success: function(data){
       console.log('Upload successfully');
       var screenshot_name = JSON.parse(data);
       console.log(screenshot_name);
        //oldwritten
        $.ajax({
          url:"ussdMenu_backend.php",
          method:'POST',
          data:{name:$('#menuNameInput').val(),admin_id:admin_id,editmenuJson:myDiagram.model.toJson(),menuId:myParam, image_file_name: screenshot_name},
          success:function(response)
          {
            
            if(JSON.parse(response)==true)
            {
              window.location.href="ussd_menu_list.html?message=Menu Updated Successfully";
            }
            else if(JSON.parse(response)=="Already Exists")
            {
             error_backend=true;
             $('#error_div').show();
             $('#error_div').text('Please Fix The Following Error(s)');
            $('#menInErr').text('Menu With Similar Name Already Exists'); 
            }
            else if(JSON.parse(response)=='Illicit User')
            {
              error_backend=true;
              window.location.href="ussd_menu_list.html";
            }
            else
            {
              $('#error_div').show();
             $('#error_div').text('There Was Some Issue Saving The Menu.Please Try Again Later');
            }
          }
        });
      }
      });
      }

    });

    $('#menuNameInput').on('keypress',function(e){
      if(error_backend==true)
      {
        $('#menInErr').text('');
        $('#error_div').hide();
        error_backend=false;
      }
    });
    function load() {
      myDiagram.model = go.Model.fromJson(document.getElementById("mySavedModel").value);
    }


  </script>
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <!--<button type="button" class="close" data-dismiss="modal">&times;</button>-->
          <div class="alert alert-danger" id="errorDiv" hidden="">
  <strong>Danger!</strong> Please Fix The Following Errors To Proceed.
</div>
          <h4 class="modal-title">USSD Menu Options</h4>
        </div>
        <form id="ex2form">
        <div class="modal-body">
         
            <div class="form-group">
               <label for="mName" class="col-sm-2 col-form-label">Name*</label>
               <div class="col-sm-6">
              <input type="text" class="form-control inputText col-sm-2" id="mName" placeholder="Enter Menu Name">
              </div>
            </div>
          <div class="form-group">
             <label for="mainOptions" class="col-sm-2 col-form-label">Type*</label>
             <div class="col-sm-6">
             <select class="form-control col-sm-2" name="mainOptions" id="optionList">
              <option value='default'>Select An Option</option>
          <?php
          for($i=0;$i<sizeof($menu);$i++)
          {
          ?>
          <option value="<?php echo $menu[$i];?>"><?php echo $menu[$i];?></option>
          <?php
            }
          ?>
        </select>

        </div>
          </div>
          <div class="form-group jumpMenu" hidden="">
            <div class="col-sm-2">
              <label for="jumpOpt">Option</label>
            </div>
            <div class="col-sm-6">
            <select class="form-control col-sm-2" id="jumpOpt">
              <option id="defaultJump">Select Jump Menu</option>
            </select>
            </div>
          </div>

          <div class="form-group" id="langDiv">
            <label for="language" class="col-sm-2 col-form-label">Language*</label>
            <div class="col-sm-6">
              <?
              for($i=0;$i<sizeof($langArr);$i++)
              {
              ?>
              <input type="checkbox" class="langclss" value="<?echo $langArr[$i];?>" name="lang" id="lang_<?echo $i; ?>"> &nbsp;<?echo $langArr[$i];?>
              <?
              }
              ?>
            </div>
          </div>
          <div class="form-group optDiv" hidden="" id="textDiv">
            <label for="description" class="col-sm-2 col-form-label">Description*</label>
            <div class="col-sm-6">
                <textarea class="form-control rounded-0" id="txtarea" cols="45" rows="5" style="width: 200px; height: 100px; overflow: hidden;white-space: pre-line"></textarea>
            </div>

            <div class="col-sm-6">
              <span id="spanId" style="text-align: center"></span>
            </div>
          </div>

          <div class="form-group endDescp" hidden="" id="endDescpId">
            <div class="col-sm-6">
              <span id="spanId2" style="text-align: center"></span>
            </div>
            <label for="end_descp">End Message*</label>
            <div class="col-sm-6">
              <textarea class="form-control rounded-0" id="endDescpTxtArea" cols="45" rows="5" style="width: 200px; height: 100px; overflow: hidden;"></textarea>
            </div>
            
          </div>

          <div class="optDiv" id="lableDiv" hidden="">
            <label for="description" class="col-sm-2 col-form-label">Options*</label>
          </div>
          <div class="apiDiv" hidden="">
            <div>
           <label for="urlName" class="col-sm-2 col-form-label">URL*</label>
           <input type="text" name="urlName" id="urlName" placeholder="Enter Url">
            </div>
           <label for ="apiType">API Method*</label>
           <select name="apiType" id="apiType">
             <option>GET</option>
             <option>POST</option>
           </select>
           <div>
           <label for="params">Parameters*</label> 
           <div class="rowParam">
           <input type="text" name="params" placeholder="Enter Parameter Name" class="params"> &nbsp;&nbsp; <input type="text" placeholder="Enter Parameter Value" name="paramsVal" class="paramsVal "> <img id="addNew" src="css/pie/plus (1).png">
           </div>
         </div>
          </div>
          <div id="inputParamsDiv" hidden="">
           <label for="params">Parameters*</label>
           <div>
           <input type="text" name="inputparams" id="inputParamsId" placeholder="Enter Parameter Name" class="inputparams">
           </div>
           
            <!--<div>
            <input id="inputparamsValId" type="text" placeholder="Enter Parameter Value" name="inputparamsVal" class="inputparamsVal "> 
          </div>-->
        </div>

          <div id="keypaddiv" hidden="">
            <?

             for($i=0;$i<sizeof($keypad);$i++)
              {
              ?>
              <div class="controls controls-row" style="margin-left:-30px;">
              <div class="span1">
    <input type="checkbox" class="keypadCls" id="key_<?php echo $i;?>" value="<?php echo($keypad[$i]);?>"><?php echo " " .$keypad[$i];?>
  </div>
        <div>
              <!--<input type="text" class="span3 inputText " placeholder="Enter Details" name="date" id="input_<?=$i;?>" placeholder=" date">-->
              </div>
          </div>
              <?
              }
              ?>
            </div>

          </div>
        </div>
        <div class="modal-footer">
          <!--<button type="button" style="float: right;" class="btn btn-save" id="saveBtn">Save</button>-->
          <input type="submit" name="Save" style="float: right;" class="btn btn-save" id="saveBtn" value="Save" >
          <button type="button" id="close-me" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </form>
      </div>
      
    </div>
  </div>
</body>
</html>
<script type="text/javascript">
  $(document).ready(function(){
    var allowedEnglishCharacters="180";
  var allowedOtherCharacters="80";
    $('.langclss').on('click',function(e){
      //alert("Here");
      if($(this).attr('checked'))
      {
        $(this).removeAttr("checked");
        $('#allowedChars').val(allowedEnglishCharacters);
        $('#spanId').text(allowedEnglishCharacters+" Characters Left");
        $('#spanId2').text(allowedEnglishCharacters+" Characters Left");
        $("#selectedlanguage").val("English");
        
      }
      else
      {
        $(this).attr('checked',true);
        $('#allowedChars').val(allowedOtherCharacters);
        $('#spanId').text(allowedOtherCharacters+" Characters Left");
        $('#spanId2').text(allowedOtherCharacters+" Characters Left");
        $("#selectedlanguage").val("Multi");

      }
    });

$('#addNew').on('click',function(e){
var ele=$("<div class=rowParam><input type=text placeholder='Enter Parameter Name' name=params class=params> &nbsp;&nbsp; <input type=text placeholder='Enter Parameter Value' name=paramsVal class=paramsVal> <img id=delNew src='css/pie/minus.png'></div>");
ele.insertAfter($(".rowParam").last());
});

$(document).on('click','#delNew',function(){$(this).parent("div").remove();})
  });

</script>
