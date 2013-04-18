<html>
<head>
<script language="javascript">
function addRowToTable(){
  var tbl = document.getElementById('tblSample');
  var lastRow = tbl.rows.length;
  // if there's no header row in the table, then iteration = lastRow + 1
  var iteration = lastRow+1;
  var row = tbl.insertRow(lastRow);
    // left cell
  var cellLeft = row.insertCell(0);
  var textNode = document.createTextNode(iteration);
  cellLeft.appendChild(textNode);
    // right cell
  var cellRight = row.insertCell(1);
  var el = document.createElement('input');
  el.setAttribute('type', 'text');
  el.setAttribute('name', 'txtRow' + iteration);
  el.setAttribute('id', 'txtRow' + iteration);
  el.setAttribute('size', '40');
  //el.onkeypress = keyPressTest;
  cellRight.appendChild(el);
}

function expand(divid,obj) {
  var divhgt = document.getElementById(divid);
  var linkid = document.getElementById(obj);
  linkid.innerHTML = (linkid.innerHTML.indexOf('+') != -1) ? "<b> - </b>" : "<b> + </b>";
  divhgt.style.overflow = (divhgt.style.overflow == "hidden") ? "visible" : "hidden";
}

function removeRowFromTable(){
  var tbl = document.getElementById('tblSample');
  var lastRow = tbl.rows.length;
  if (lastRow > 1) tbl.deleteRow(lastRow - 1);
}
</script>
</head>
<body>
<form action="tableaddrow_nw.html" method="get">
<p>
<input type="button" value="Add" onclick="addRowToTable();" />
<input type="button" value="Remove" onclick="removeRowFromTable();" />
</p>
<table border="1" id="tblSample1">
  <tr>
    <th colspan="2">Sample table   <a href="javascript:void(0)" id="ansprechlnk" onclick="expand('expblock',this.id)"><b> + </b></a></th>
  </tr>
  <tr><td colspan="2">
  <div id="expblock" style="position:relative; height:60px; overflow:hidden;">
     <table border="1" id="tblSample">
       <tr><td>1</td>
          <td><input type="text" name="txtRow1" id="txtRow1" size="40" onkeypress="keyPressTest(event, this);"/></td>
      </tr>
      <tr><td>2</td>
          <td><input type="text" name="txtRow2" id="txtRow2" size="40" onkeypress="keyPressTest(event, this);"/></td>
      </tr>
      <tr><td>3</td>
          <td><input type="text" name="txtRow3" id="txtRow3" size="40" onkeypress="keyPressTest(event, this);"/></td>
      </tr>
    </table>
  </div>
  </td></tr>
</table>

<blockquote>Testing what happens when rows are dynamically added to the above table. Testing position of a div tag.</blockquote>
</form>
</body>
</html>