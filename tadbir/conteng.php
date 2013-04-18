
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 tdansitional//EN" 
    "http://www.w3.org/td/html4/loose.dtd">

<html>
<head>
<title>untitled</title>
<style type="text/css">

#alltopics {
	width: 400px;
	margin: 40px auto;
	border: 1px #000 solid;
	background: #eaa;
}
tr.topic td {
	font: bold 12px verdana;
	color: #fff;
	text-align: center;
	padding: 3px;
	border: 3px #fff inset;
	background: #a00;
	cursor: pointer;
}
tr.subtopic {
	display: none;
}
tr.subtopic td {
	display: block;
	font: normal 11px verdana;
	color: #000;
	text-align: center;
	padding: 1px;
	margin: 0;
	border: 1px #f88 solid;
	background: #ccc;
}

</style>
<script type="text/javascript">

function TDClick(e)
{
	e = (e) ? e : window.event;
	var cell = (e.srcElement) ? e.srcElement : (e.target) ? e.target : null;
	var row = (cell) ? cell.parentNode : null;
	if (row && row.className == 'topic')
	{
		var tr, CSSdisplay = 'none', s = 0;
		for (s; s < TDClick.topics.length; ++s)
		{
			tr = TDClick.topics[s];
			if (tr.className == 'topic')
			{
				if (row == tr)
					CSSdisplay = (row.style.display != 'inline') ? 'inline' : 'none';
				else CSSdisplay = 'none';
			}
			else if (tr.className == 'subtopic')
				tr.style.display = (tr.style.display != 'inline') ? CSSdisplay : 'none';
		}
	}	
}

onload = function()
{
	TDClick.topics = new Array();
	var tr, i = 0, trs = document.getElementById('alltopics').getElementsByTagName('tr');
	while (tr = trs.item(i++))
		if (tr.className.match(/(sub)?topic/))
			TDClick.topics[TDClick.topics.length] = tr;

	var obj = document.getElementsByTagName('body').item(0);
	if (obj.addEventListener)
		obj.addEventListener('click', function(e) { return TDClick(e); }, true);
	else if (obj.attachEvent)
		obj.attachEvent('onclick', function(e) { return TDClick(e); });
	else
	{
		var oldhandler = obj.onclick;
		if (null != oldhandler)
			obj.onclick = function(e) { oldhandler(e); TDClick(e); }; 
		else obj.onclick = function(e) { return TDClick(e) };
	}
}

</script>
</head>
<body>
<table id="alltopics">
   <thead>
   </thead>
   <tbody>
      <tr class="topic">
         <td>• Topic 1 •</td>
      </tr><tr class="subtopic">
         <td><strong>Subtopic A: </strong>blah  blah  blah  blah  blah  blah  blah  blah  blah  blah  blah</td>
      </tr><tr class="subtopic">
         <td><strong>Subtopic B: </strong>blah  blah  blah  blah  blah  blah  blah  blah  blah  blah  blah</td>
      </tr><tr class="topic">
         <td>• Topic 2 •</td>
      </tr><tr class="subtopic">
         <td><strong>Subtopic A: </strong>blah  blah  blah  blah  blah  blah  blah  blah  blah  blah  blah</td>
      </tr><tr class="subtopic">
         <td><strong>Subtopic B: </strong>blah  blah  blah  blah  blah  blah  blah  blah  blah  blah  blah</td>
      </tr><tr class="topic">
         <td>• Topic 3 •</td>
      </tr><tr class="subtopic">
         <td><strong>Subtopic A: </strong>blah  blah  blah  blah  blah  blah  blah  blah  blah  blah  blah</td>
      </tr><tr class="subtopic">
         <td><strong>Subtopic B: </strong>blah  blah  blah  blah  blah  blah  blah  blah  blah  blah  blah</td>
      </tr><tr class="subtopic">
         <td><strong>Subtopic C: </strong>blah  blah  blah  blah  blah  blah  blah  blah  blah  blah  blah</td>
      </tr>
   </tbody>
</table>
</body>
</html>