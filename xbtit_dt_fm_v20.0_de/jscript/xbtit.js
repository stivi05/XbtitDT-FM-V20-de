    var newwindow;
    function popdetails(url) {
        newwindow=window.open(url,'popdetails','height=500,width=500,resizable=yes,scrollbars=yes,status=yes');
        if (window.focus) newwindow.focus();
    }

    function poppeer(url) {
        newwindow=window.open(url,'poppeers','height=400,width=650,resizable=yes,scrollbars=yes');
        if (window.focus) newwindow.focus();
    }

    function PopRip() {
        newWin=window.open('nforipper.php','NFO Ripper','height=400,width=500,resizable=yes,scrollbars=yes');
        if (window.focus) {newWindow.focus()}
    }

    function gallery(url) {
        newwindow=window.open(url,'Gallery','height=400,width=650,resizable=yes,scrollbars=yes');
        if (window.focus) newwindow.focus();
    }

    function resize(img) {
        if (img.width>500) {
            img.height=parseInt(img.height*500/img.width);
            img.width=500;
            img.title='Click on image for full size view.';
            var foo=document.getElementById(img.name);
            foo.innerHTML='<strong>Click on image for full size view.</strong><br /><a href="'+img.src+'" target="_blank">'+foo.innerHTML+'</a>';
        }
    }

    function resize_avatar(img) {
        if(img.width>80) {
            img.height=parseInt(img.height*80/img.width);
            img.width=80;
        }
    }
    function editup(id,uid){newWin=window.open('chatedit.php?action=edit&msgid='+id,'edit','height=300,width=490,resizable=yes,scrollbars=yes');if(window.focus){newWin.focus()}}