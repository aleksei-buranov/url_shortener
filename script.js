'use strict';

document.addEventListener("DOMContentLoaded", function() {
    let responseBlock = document.querySelector('#response');

    let shortForm = document.querySelector('form[name=formShort]');

    shortForm.addEventListener('submit',function (e) {
        e.preventDefault();

        let userUrl = encodeURIComponent(shortForm.elements.url.value);
        let req = new XMLHttpRequest();

        req.open('POST', 'main.php');

        req.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

        req.send('url='+userUrl);

        req.onreadystatechange = function(){
            if (req.readyState===4 && req.status === 200){
                responseBlock.innerHTML=req.responseText;
            }
        }

    });
});