<!DOCTYPE html> 
<html lang="en">
<head>
  <title>Javascript CSV parser with HTML5 File Reader</title>
  <style type="text/css">
    body {
      font: 12px/20px "Lucida Grande", Tahoma, Verdana, sans-serif;
      color: #404040;
      background: #47496D;
      background-image: -webkit-radial-gradient(center, circle cover, #6b6e8c, #212649);
      background-image: -moz-radial-gradient(center, circle cover, #6b6e8c, #212649);
      background-image: -o-radial-gradient(center, circle cover, #6b6e8c, #212649);
      background-image: radial-gradient(center, circle cover, #6b6e8c, #212649);
    }
    #wrap{
      margin: 80px auto;
      width: 960px;
      padding: 10px;
      overflow: hidden;
      background: #FAFAFA;
      border-radius: 4px;
      -webkit-box-shadow: 0 0 4px rgba(0, 0, 0, 0.4);
      box-shadow: 0 0 4px rgba(0, 0, 0, 0.4);
    }
    form{
      background: #CCC;
      border-radius: 2px;
      padding: 10px;
    }
    table {
      max-width: 100%;
      background-color: #fff;
      border-collapse: collapse;
      border-spacing: 0;
      width: 100%;
      margin-bottom: 20px;
    }
    table th{
      background: #eae4ff;
    }
    table th,
    table td {
      padding: 8px;
      line-height: 20px;
      text-align: left;
      vertical-align: top;
      border-top: 1px solid #dddddd;
    }
    table {
      border: 1px solid #dddddd;
      border-collapse: separate;
      *border-collapse: collapse;
      border-left: 0;
      -webkit-border-radius: 4px;
         -moz-border-radius: 4px;
              border-radius: 4px;
    }
    table th,
    table td {
      border-left: 1px solid #dddddd;
    }

    table tr:nth-child(odd){
      background-color: #f9f9f9;
    }

    table tr:hover td
    {
      background-color: #f5f5f5;
    }

    table tr:first-child{
      font-weight: bold;
    }
  </style>
</head>
<body>
  <div id="wrap">
    <h1>HTML5 and Javascript CSV Parser</h1>
    <form action="javascript:void(0);" id="the_form">
      <input type="file" id="the_file" required="required" accept=".csv"/>
      <input type="submit" value="Go" class="btn"/>
    </form>
    <div id="file_info"></div>
    <div id="list"></div>
  </div>
<script type="text/javascript">

  function fileInfo(e){
    var file = e.target.files[0];
    if (file.name.split(".")[1].toUpperCase() != "CSV"){
      alert('Invalid csv file !');
      e.target.parentNode.reset();
      return;
    }else{
      document.getElementById('file_info').innerHTML = "<p>File Name: "+file.name + " | "+file.size+" Bytes.</p>";
    }
  }
 function handleFileSelect(){
  var file = document.getElementById("the_file").files[0];
  var reader = new FileReader();
  var link_reg = /(http:\/\/|https:\/\/)/i;
  reader.onload = function(file) {
              var content = file.target.result;
              var rows = file.target.result.split(/[\r\n|\n]+/);
              var table = document.createElement('table');
              
              for (var i = 0; i < rows.length; i++){
                var tr = document.createElement('tr');
                var arr = rows[i].split(',');

                for (var j = 0; j < arr.length; j++){
                  if (i==0)
                    var td = document.createElement('th');
                  else
                    var td = document.createElement('td');

                  if( link_reg.test(arr[j]) ){
                    var a = document.createElement('a');
                    a.href = arr[j];
                    a.target = "_blank";
                    a.innerHTML = arr[j];
                    td.appendChild(a);
                  }else{
                    td.innerHTML = arr[j];
                  }
                  tr.appendChild(td);
                }

                table.appendChild(tr);
              }

              document.getElementById('list').appendChild(table);
          };
  reader.readAsText(file);
 }
 document.getElementById('the_form').addEventListener('submit', handleFileSelect, false);
 document.getElementById('the_file').addEventListener('change', fileInfo, false);

</script>


</body>
</html>
