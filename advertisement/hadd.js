var pp = path+"showadd.php";  
path1 = path.replace(/\//g,"%2F");
pp = pp+"?campaign="+campaign+"&str="+path1;  
document.write("<ifr"+"ame src="+pp+" style=\"border: 0px solid #ffffff;\" width="+width+" height="+height+" marginwidth=0 marginheight=0 vspace=0 hspace=0 frameborder=0 allowtransparency=true scrolling=no"+">"+"</if"+"rame"+">"); 