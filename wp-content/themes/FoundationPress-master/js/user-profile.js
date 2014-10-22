(function(swra){
  function swrb(){
    var e=swra("#new_password").val(),d=swra("#user_name").val(),c=swra("#pwd2").val(),f;
    swra("#swr-pass-strength-result").removeClass("short bad good strong");
    if(!e){swra("#swr-pass-strength-result").html("Strength indicator");return}
    f=passwordStrength(e,d,c);
    switch(f){
      case 2:swra("#swr-pass-strength-result").addClass("bad").html("Weak");
      break;
      case 3:swra("#swr-pass-strength-result").addClass("good").html("Medium");
      break;
      case 4:swra("#swr-pass-strength-result").addClass("strong").html("Strong");
      break;
      case 5:swra("#swr-pass-strength-result").addClass("short").html("Mismatch");
      break;
      default:swra("#swr-pass-strength-result").addClass("short").html("Very weak")
    }
  }
  swra(document).ready(function(){
    swra("#new_password").val("").keyup(swrb);
    swra("#pwd2").val("").keyup(swrb);
  })
})(jQuery);

(function(swrc){
  function swrd(){
    var e=swrc("#new_password2").val(),d=swrc("#newPwdLogin").val(),c=swrc("#pwd3").val(),f;
    swrc("#swr-pass-strength-result2").removeClass("short bad good strong");
    if(!e){swrc("#swr-pass-strength-result2").html("Strength indicator");return}
    f=passwordStrength(e,d,c);
    switch(f){
      case 2:swrc("#swr-pass-strength-result2").addClass("bad").html("Weak");
      break;
      case 3:swrc("#swr-pass-strength-result2").addClass("good").html("Medium");
      break;
      case 4:swrc("#swr-pass-strength-result2").addClass("strong").html("Strong");
      break;
      case 5:swrc("#swr-pass-strength-result2").addClass("short").html("Mismatch");
      break;
      default:swrc("#swr-pass-strength-result2").addClass("short").html("Very weak")
    }
  }
  swrc(document).ready(function(){
    swrc("#new_password2").val("").keyup(swrd);
    swrc("#pwd3").val("").keyup(swrd);
  })
})(jQuery);

function passwordStrength(f,i,d){
  var k=1,h=2,b=3,a=4,c=5,g=0,j,e;
  if((f!=d)&&d.length>0){
    return c
  }
  if(f.length<4){
    return k
  }
  if(f.toLowerCase()==i.toLowerCase()){
    return h
  }
  if(f.match(/[0-9]/)){
    g+=10
  }
  if(f.match(/[a-z]/)){
    g+=26
  }
  if(f.match(/[A-Z]/)){
    g+=26
  }
  if(f.match(/[^a-zA-Z0-9]/)){
    g+=31
  }
  j=Math.log(Math.pow(g,f.length));
  e=j/Math.LN2;
  if(e<40){
    return h
  }
  if(e<56){
    return b
  }
  return a
};