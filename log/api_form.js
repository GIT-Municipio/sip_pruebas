// JavaScript Document

var myForm, resObj;

function doOnLoad() {

    formData = [

        { type: "settings", position: "label-left", labelWidth: 50, inputWidth: "auto" },
        {
            type: "block",
            className: "class_fondoform",
            label: "Crear Nuevo Objetivo",
            offsetLeft: 0,
            offsetRight: 5,
            offsetTop: 0,
            inputWidth: "auto",
            list: [
                { type: "input", label: "Usuario", width: 195, name: "login", value: "" },
                { type: "password", label: "Clave", width: 195, offsetTop: 15, name: "pwd", value: "" },
                { type: "button", value: "  Aceptar  ", name: "send", id: "send", offsetLeft: 80, offsetTop: 15, width: 100, className: "boton_aceptar" },

            ]
        },
    ];

    myForm = new dhtmlXForm("myForm", formData);

    function enviarformulario() {
        myForm.send("server.php", function(loader, response) {

            // alert(response);
            // if (response == "block") {
            //     /* 
            // 				dhtmlx.alert({
            // 				title:"Atencion!",
            // 				 type:"alert-error",
            // 			    text: "Tiene una session abierta!!",
            // 			    callback: function() {  document.location.href="index.php"; }
            // 				});*/
            //     var seslogin = myForm.getItemValue("login");
            //     var sespasw = myForm.getItemValue("pwd");
            //     //alert(seslogin);								
            //     document.location.href = 'reabrirsession.php?seslogin=' + seslogin + '&sespasw=' + sespasw;
            //     ////////////////////////////////////////
            // } else}
            if (response == "bien" || response == "block") {
                document.location.href = "../index.php";

            } else {
                dhtmlx.alert({
                    title: "Mensaje!",
                    type: "alert-error",
                    text: "El Usuario y Clave no coinciden!!",
                    callback: function() { document.location.href = "index.php"; }
                });
            }
        });
    };

    myForm.attachEvent("onEnter", function(id) {
        enviarformulario();
    });

    myForm.attachEvent("onButtonClick", function(id) {

        if (id == "send") {
            enviarformulario();
        }
    });
    ///////////////////////////////////////////////////
}