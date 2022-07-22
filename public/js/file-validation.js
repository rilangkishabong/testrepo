$("#trfare").change(function(e) {
    e.preventDefault();
    debugger;
    var fileInput =
        document.getElementById('trfare');
    var numFiles = $(this).get(0).files.length;
    var flg1 = 1; //ok
    for (i = 0; i < numFiles; i++) {
        var fileNm = fileInput.files[i].name;
        var fileExtension = fileNm.replace(/^.*\./, '');
        var filesize = (this.files[i].size / 1024 / 1024).toFixed(2);
        if (filesize > 0.3) {
            flg1 = 0;
            break;
        } else if (fileExtension.includes("jpg") || fileExtension.includes("jpeg") || fileExtension.includes("png")) {
            flg1 = 1;
        } else {
            flg1 = 2;
            break;
        }
    }
    if (flg1 == 0) {
        alert("File size max is 300 kb");
        fileInput.value = '';
        return false;
    } else if (flg1 == 2) {
        alert('Invalid file type');
        fileInput.value = '';
        return false;
    }
});

$("#tourrept").change(function(e) {
    e.preventDefault();
    var fileInput =
        document.getElementById('tourrept');
    var flg1 = 1; //ok
    var fileNm = fileInput.files[0].name;
    var fileExtension = fileNm.replace(/^.*\./, '');
    var filesize = (this.files[0].size / 1024 / 1024).toFixed(2);
    if (filesize > 0.3) {
        flg1 = 0;
    } else if (fileExtension.includes("pdf")) {
        flg1 = 1;
    } else {
        flg1 = 2;
    }

    if (flg1 == 0) {
        alert("File size max is 300 kb");
        fileInput.value = '';
        return false;
    } else if (flg1 == 2) {
        alert('Invalid file type');
        fileInput.value = '';
        return false;
    }
});

$("#lodgfare").change(function(e) {
    e.preventDefault();
    var fileInput =
        document.getElementById('lodgfare');
    var numFiles = $(this).get(0).files.length;
    var flg1 = 1; //ok
    for (i = 0; i < numFiles; i++) {
        var fileNm = fileInput.files[i].name;
        var fileExtension = fileNm.replace(/^.*\./, '');
        var filesize = (this.files[i].size / 1024 / 1024).toFixed(2);
        if (filesize > 0.3) {
            flg1 = 0;
            break;
        } else if (fileExtension.includes("jpg") || fileExtension.includes("jpeg") || fileExtension.includes("png")) {
            flg1 = 1;
        } else {
            flg1 = 2;
            break;
        }
    }
    if (flg1 == 0) {
        alert("File size max is 300 kb");
        fileInput.value = '';
        return false;
    } else if (flg1 == 2) {
        alert('Invalid file type');
        fileInput.value = '';
        return false;
    }
});

$("#other_exp").change(function(e) {
    e.preventDefault();
    var fileInput =
        document.getElementById('lodgfare');
    var numFiles = $(this).get(0).files.length;
    var flg1 = 1; //ok

    for (i = 0; i < numFiles; i++) {
        var fileNm = fileInput.files[i].name;
        var fileExtension = fileNm.replace(/^.*\./, '');
        var filesize = (this.files[i].size / 1024 / 1024).toFixed(2);
        if (filesize > 0.3) {
            flg1 = 0;
            break;
        } else if (fileExtension.includes("jpg") || fileExtension.includes("jpeg") || fileExtension.includes("png")) {
            flg1 = 1;
        } else {
            flg1 = 2;
            break;
        }
    }
    if (flg1 == 0) {
        alert("File size max is 300 kb");
        fileInput.value = '';
        return false;
    } else if (flg1 == 2) {
        alert('Invalid file type');
        fileInput.value = '';
        return false;
    }
});
