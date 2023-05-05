
function openForm() {
  document.getElementById("showForm").style.display = "block";
  document.getElementById("showBackground").style.display = "block";
}

function closeForm() {
  document.getElementById("showForm").style.display = "none";
  document.getElementById("showBackground").style.display = "none";

  var radios = document.getElementsByName('groupOfimages');
  for (var i = 0; i < radios.length; i++) {
     radios[i].checked = false;
  }

}