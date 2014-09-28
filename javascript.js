
function confirmDelete()
{
var agree=confirm("Are you sure you wish to delete this?");
if (agree)
	return true ;
else
	return false ;
}

function confirmSubmit()
{
var agree=confirm("Are you sure you wish to submit this?");
if (agree)
	return true ;
else
	return false ;
}

function confirmPrint()
{
var agree=confirm("Are you sure you wish to print this expenditure?");
if (agree)
	return true ;
else
	return false ;
}

function validate_field(field,alerttxt)
{
with (field)
  {
  if (value==null||value=="")
    {
    alert(alerttxt);
    return false;
    }
  else
    {
    return true;
    }
  }
}
