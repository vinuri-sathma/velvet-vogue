function checkForm(){
 let email=document.getElementById("email").value;
 if(!email.includes("@")){
  alert("Enter valid email");
  return false;
 }
}
