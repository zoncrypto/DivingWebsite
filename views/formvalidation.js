/* Diver Signup Form Validation - starts here*/
document.getElementById('name').addEventListener('blur',validateName);
document.getElementById('pass').addEventListener('blur',validatePassword);
document.getElementById('phone').addEventListener('blur',validatePhone);

function validateName(){
const name=document.getElementById('name');
const re=/^[a-zA-Z0-9]{2,10}$/;

if(!re.test(name.value)){
name.classList.add('is-invalid');
}else
name.classList.remove('is-invalid');
}

function validatePassword(){
const pass=document.getElementById('pass');
const re=/^[a-zA-Z0-9]{5,10}$/;

if(!re.test(pass.value)){
pass.classList.add('is-invalid');
}else
pass.classList.remove('is-invalid');
}



function validatePhone(){
  const phone=document.getElementById('phone');
const re=/^\(?\d{3}\)?[-. ]?\d{3}[-. ]?\d{4}$/;

if(!re.test(phone.value)){
phone.classList.add('is-invalid');
}else
phone.classList.remove('is-invalid');
}
/* Diver Signup Form Validation - ends here*/
/* ----------------------------------------*/
/*Dive Center Form Validation - starts here*/
document.getElementById('centeruname').addEventListener('blur',validateCenterUName);
document.getElementById('centerpass').addEventListener('blur',validateCenterPassword);
document.getElementById('centerphone').addEventListener('blur',validateCenterPhone);


function validateCenterUName(){
  const name=document.getElementById('centeruname');
  const re=/^[a-zA-Z0-9]{2,10}$/;
  
  if(!re.test(name.value)){
  name.classList.add('is-invalid');
  }else
  name.classList.remove('is-invalid');
}

function validateCenterPassword(){
  const pass=document.getElementById('centerpass');
  const re=/^[a-zA-Z0-9]{5,10}$/;
  
  if(!re.test(pass.value)){
  pass.classList.add('is-invalid');
  }else
  pass.classList.remove('is-invalid');
  }
  
  
  
  function validateCenterPhone(){
    const phone=document.getElementById('centerphone');
  const re=/^\(?\d{3}\)?[-. ]?\d{3}[-. ]?\d{4}$/;
  
  if(!re.test(phone.value)){
  phone.classList.add('is-invalid');
  }else
  phone.classList.remove('is-invalid');
  }

/*Dive center signup validation - end*/




/*
function validateEmail(){
  const email=document.getElementById('email');
const re= /^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/;

if(!re.test(email.value)){
email.classList.add('is-invalid');
}else
email.classList.remove('is-invalid');
}

function validateZip(){
const zip=document.getElementById('zip');
const re=/^[0-9]{5}(-[0-9]{4})?$/;

if(!re.test(zip.value)){
zip.classList.add('is-invalid');
}else
zip.classList.remove('is-invalid');
}
*/