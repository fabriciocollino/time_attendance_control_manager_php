<?php require_once dirname(__FILE__) . '/../_ruta.php'; ?>
<?php require_once APP_PATH . '/controllers/' . basename(__FILE__, '-editar.html.php') . '.php'; ?>


<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
        &times;
    </button>
    <h4 class="modal-title" id="modalTitle"><?php if ($o_Usuario->getId() == null) echo _("Agregar Usuario");
        else echo _("Editar Usuario"); ?></h4>
</div>
<div class="modal-body" style="padding-top: 0px;">


    <form class="smart-form" novalidate="novalidate" data-async method="post" id="editar-form"
          action="<?php echo 'ajax/' . $Item_Name . '.html.php' ?>?tipo=<?php if ($o_Usuario->getId() == null) echo "add";
          else echo "edit&id=" . $o_Usuario->getId(); ?>">
        <?php if ($o_Usuario->getId() != null) echo '<input type="hidden" id="ItemID" name="ItemID" value="' . $o_Usuario->getId() . '">'; ?>


        <fieldset>
            <legend>Datos de Acceso</legend>
            <div class="row">

                <section class="col col-6">
                    <label class="input"> <i class="icon-prepend fa fa-envelope-o"></i>
                        <input type="email" name="email" placeholder="E-mail"
                               value="<?php echo htmlentities($o_Usuario->getEmail(), ENT_COMPAT, 'utf-8'); ?>">
                    </label>
                </section>

                <section class="col col-6">
                    <label class="select"> <span class="icon-prepend fa fa-star"></span>
                        <?php if (!isset($T_Modificar) || Registry::getInstance()->Usuario->getTipoUsuarioObject()->getCodigo() == 99 || Registry::getInstance()->Usuario->getTipoUsuarioObject()->getCodigo() > $o_Usuario->getTipoUsuarioObject()->getCodigo()): ?>
                        <select name="usuario_tipo" style="padding-left: 32px;">
                            <?php echo $T_UsuarioTipo; ?>
                        </select> <i></i> </label>
                    <?php else: ?>
                        <?php echo htmlentities($o_Usuario->getTipoUsuarioObject()->getDetalle(), ENT_COMPAT, 'utf-8'); ?>
                    <?php endif; ?>
                </section>
            </div>
            <div class="row">
                <section class="col col-6">
                    <label class="input"> <i class="icon-prepend fa fa-key"></i>
                        <input name="clave" id="clave" class="form-control" placeholder="Contraseña" type="password">
                    </label>
                </section>
                <section class="col col-6">
                    <label class="input"> <i class="icon-prepend fa fa-key"></i>
                        <input name="re_clave" class="form-control" placeholder="Repita la Contraseña" type="password">
                    </label>
                </section>
            </div>
        </fieldset>


        <fieldset>
            <legend>Datos del Usuario</legend>
            <div class="row">
                <section class="col col-6">
                    <label class="input"> <i class="icon-prepend fa fa-user"></i>
                        <input type="text" name="nombre" placeholder="Nombre"
                               value="<?php echo htmlentities($o_Usuario->getNombre(), ENT_COMPAT, 'utf-8'); ?>">
                    </label>
                </section>
                <section class="col col-6">
                    <label class="input"> <i class="icon-prepend fa fa-user"></i>
                        <input type="text" name="apellido" placeholder="Apellido"
                               value="<?php echo htmlentities($o_Usuario->getApellido(), ENT_COMPAT, 'utf-8'); ?>">
                    </label>
                </section>
            </div>
            <div class="row">
                <section class="col col-6">
                    <label class="input"> <i class="icon-prepend fa fa-info"></i>
                        <input type="text" name="dni" placeholder="DNI"
                               value="<?php echo htmlentities($o_Usuario->getDni(), ENT_COMPAT, 'utf-8'); ?>">
                    </label>
                </section>

            </div>
            <div class="row">
                <section class="col col-6">
                    <label class="input"> <i class="icon-prepend fa fa-phone"></i>
                        <input type="tel" name="te_celular" placeholder="Teléfono Celular"
                               data-mask="+549 (999) 999-9999"
                               value="<?php echo htmlentities($o_Usuario->getTeCelular(), ENT_COMPAT, 'utf-8'); ?>">
                    </label>
                </section>
                <section class="col col-6">
                    <label class="input"> <i class="icon-prepend fa fa-phone"></i>
                        <input type="tel" name="te_personal" placeholder="Teléfono Fijo" data-mask="+549 (999) 999-9999"
                               value="<?php echo htmlentities($o_Usuario->getTePersonal(), ENT_COMPAT, 'utf-8'); ?>">
                    </label>
                </section>
            </div>


        </fieldset>

        <fieldset>
            <legend>Imagen de Perfil</legend>
            <div class="row" id="ImageUpload">
                <section class="col col-6">
                    <div class="thumbPersonaEditar">
                        <?php
                        if ($o_Usuario->getImagen() == '') {
                            echo '<img src="img/avatars/male-big.png" id="finalImg" alt="me" >';
                        } else {
                            echo '<img src="imagen.php?usu_id=' . $o_Usuario->getId() . '" id="finalImg" alt="me" >';
                        }
                        ?>
                    </div>
                    <?php if ($o_Usuario->getImagen() != '') echo '<span id="btnEliminarImagen"><a href="#" onclick="setEliminarImagen();return false;" >Eliminar Imagen</a></span>'; ?>
                </section>
                <section class="col col-6">
                    <div id="dropbox">Arrastra una imagen aquí</div>
                    <div class="upload-progress"></div>
                    <input type="file" id="fileElem" multiple="true" accept="image/*"
                           onchange="handleFiles(this.files)">

                </section>
                <input type="hidden" id="inputBorrarImagen" name="inputBorrarImagen"/>
                <input type="hidden" id="inputImageExtension" name="inputImageExtension"/>
                <input type="hidden" id="inputIMGx" name="inputIMGx"/>
                <input type="hidden" id="inputIMGy" name="inputIMGy"/>
                <input type="hidden" id="inputIMGw" name="inputIMGw"/>
                <input type="hidden" id="inputIMGh" name="inputIMGh"/>
                <input type="hidden" id="inputIMGsrc" name="inputIMGsrc" value=""/>
            </div>


        </fieldset>

    </form>


</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">
        Salir
    </button>
    <button type="submit" class="btn btn-primary" data-dismiss="modal" id="submit-editar">
        <?php if ($o_Usuario->getId() == null) echo _("Agregar");
        else echo _("Guardar"); ?>
    </button>
</div>


<script type="text/javascript">

    loadScript("js/plugin/jcrop/jquery.Jcrop.min.js", function () {
        loadScript("js/plugin/jcrop/jquery.color.min.js", pagefunction);
    });
    function pagefunction() {


        var dropbox;
        var api;
        dropbox = document.getElementById("dropbox");
        dropbox.addEventListener("dragenter", dragenter, false);
        dropbox.addEventListener("dragleave", dragleave, false);
        dropbox.addEventListener("dragover", dragover, false);
        dropbox.addEventListener("drop", drop, false);
        function defaults(e) {
            e.stopPropagation();
            e.preventDefault();
        }

        function dragenter(e) {
            $(this).addClass("active");
            defaults(e);
        }

        function dragover(e) {
            defaults(e);
        }

        function dragleave(e) {
            $(this).removeClass("active");
            defaults(e);
        }

        function drop(e) {
            $(this).removeClass("active");
            defaults(e);
            // dataTransfer -> which holds information about the user interaction, including what files (if any) the user dropped on the element to which the event is bound.
            //console.log(e);
            var dt = e.dataTransfer;
            var files = dt.files;
            handleFiles(files, e);
        }

        handleFiles = function (files, e) {
            // alert(files);
            // Traverse throught all files and check if uploaded file type is image	
            var imageType = /image.*/;
            var file = files[0];
            // check file type
            if (!file.type.match(imageType)) {
                alert("El archivo \"" + file.name + "\" no es una imagen válida.");
                return false;
            }
            // check file size
            if (parseInt(file.size / 1024) > 2050) {
                alert("La imagen \"" + file.name + "\" es muy grande");
                return false;
            }

            $('#inputImageExtension').val(file.type);

            var info = '<div class="preview active-win"><div class="preview-image"><img ></div><div class="progress-holder"><span id="progress"></span></div><span class="percents"></span><div style="float:left;">Uploaded <span class="up-done"></span> KB of ' + parseInt(file.size / 1024) + ' KB</div>';
            $("#dropbox").hide();
            $("#fileElem").hide();
            $(".upload-progress").show(function () {
                $(".upload-progress").html(info);
                uploadFile(file);
            });
        }

        uploadFile = function (file) {
            // check if browser supports file reader object 
            if (typeof FileReader !== "undefined") {
                //alert("uploading "+file.name);
                reader = new FileReader();
                reader.onload = function (e) {
                    //alert(e.target.result);
                    $('.preview img').attr('src', e.target.result).css("width", "70px").css("height", "70px");
                }
                reader.readAsDataURL(file);
                xhr = new XMLHttpRequest();
                xhr.open("post", "image_upload.php", true);
                xhr.upload.addEventListener("progress", function (event) {
                    //console.log(event);
                    if (event.lengthComputable) {
                        $("#progress").css("width", (event.loaded / event.total) * 100 + "%");
                        $(".percents").html(" " + ((event.loaded / event.total) * 100).toFixed() + "%");
                        $(".up-done").html((parseInt(event.loaded / 1024)).toFixed(0));
                    }
                    else {
                        alert("Failed to compute file upload length");
                    }
                }, false);
                xhr.onreadystatechange = function (oEvent) {
                    //console.log(oEvent);
                    //console.log(xhr);
                    if (xhr.readyState === 4) {
                        if (xhr.status === 200) {
                            $("#progress").css("width", "100%");
                            $(".percents").html("100%");
                            $(".up-done").html((parseInt(file.size / 1024)).toFixed(0));
                            //if reach here means the image uploaded ok

                            $(".upload-progress").hide();
                            $(".upload-progress").after("<div id=\"imgCropDiv\" style=\"overflow:hidden;\"><img id=\"imgCrop\" src=\"imagen.php?temp_img=" + xhr.responseText + "\" /></div>");
                            //<button type=\"button\" class=\"btn btn-default\" id=\"CancelCrop\" style=\"padding: 6px 12px;margin-top: 10px;\">Cancelar</button>
                            $("#finalImg").attr("src", "imagen.php?temp_img=" + xhr.responseText);
                            $("#inputIMGsrc").attr("value", xhr.responseText);
                            api = $('#imgCrop').Jcrop({
                                onChange: showPreview,
                                onSelect: showPreview,
                                boxWidth: 250,
                                boxHeight: 250,
                                aspectRatio: 1,
                                setSelect: [($('#imgCrop').width() / 2) - 250,
                                    ($('#imgCrop').height() / 2) - 250,
                                    ($('#imgCrop').width() / 2) + 250,
                                    ($('#imgCrop').height() / 2) + 250
                                ]
                            });
                            //$('#CancelCrop').click(function(){
                            //		debugger;
                            //	api.disable();
                            //});

                        } else {
                            alert("Error" + xhr.statusText);
                        }
                    }
                };
                // Set headers
                xhr.setRequestHeader("Content-Type", "multipart/form-data");
                xhr.setRequestHeader("X-File-Name", file.fileName);
                xhr.setRequestHeader("X-File-Size", file.fileSize);
                xhr.setRequestHeader("X-File-Type", file.type);
                // Send the file (doh)
                xhr.send(file);
            } else {
                alert("Your browser doesnt support FileReader object");
            }
        }


        function showPreview(coords) {
            var maxX = 250;
            var maxY = 250;
            var rx = maxX / coords.w;
            var ry = maxY / coords.h;
            rx = (rx == 0) ? 1 : rx;
            ry = (ry == 0) ? 1 : ry;
            photoX = $("#imgCrop").width();
            photoY = $("#imgCrop").height();
            $("#finalImg").css({
                width: Math.round(rx * photoX) + 'px',
                height: Math.round(ry * photoY) + 'px',
                marginLeft: '-' + Math.round(rx * coords.x) + 'px',
                marginTop: '-' + Math.round(ry * coords.y) + 'px'
            });
            $('#inputIMGx').val(coords.x);
            $('#inputIMGy').val(coords.y);
            $('#inputIMGw').val(coords.w);
            $('#inputIMGh').val(coords.h);
        }


    }


    $(function () {
        // Validation


        $("#editar-form").validate({
            // Rules for form validation
            rules: {
                email: {
                    required: true,
                    minlength: 4,
                    maxlength: 50,
                    email: true,
                    remote: {
                        url: "<?php echo 'ajax/' . $Item_Name . '.html.php' ?>",
                        type: "post",
                        data: {'tipo': 'check', 'tipo_check': 'c_usuario', 'id': $("#ItemID").val()},
                        dataFilter: function (data) {
                            if (data.responseText !== "true") {
                                return "\"" + data + "\"";
                            } else {
                                return success;
                            }
                        }
                    }
                },
                <?php if ($o_Usuario->getId() == null): ?>
                clave: {
                    required: true,
                    minlength: 6,
                    maxlength: 50
                },
                re_clave: {
                    //required : true,
                    equalTo: "#clave"
                },
                <?php endif; ?>
                nombre: {
                    required: true
                },
                apellido: {
                    required: true
                },
                telefono: {
                    required: false
                },
                dni: {
                    required: false,
                    minlength: 8,
                    maxlength: 8,
                    remote: {
                        url: "<?php echo 'ajax/' . $Item_Name . '.html.php' ?>",
                        type: "post",
                        data: {'tipo': 'check', 'tipo_check': 'c_dni', 'id': $("#ItemID").val()},
                        dataFilter: function (data) {
                            if (data.responseText !== "true") {
                                return "\"" + data + "\"";
                            } else {
                                return success;
                            }
                        }
                    }
                },
                tag: {
                    required: false,
                    minlength: 10,
                    maxlength: 10
                },
                equipo: {
                    required: false
                },
                usuario_tipo: {
                    required: true
                },
                te_celular: {
                    required: false
                }
            },
            // Messages for form validation
            messages: {
                usuario: {
                    required: '<?php echo _('Por favor ingrese el nombre de usuario') ?>',
                    minlength: '<?php echo _('El Usuario es muy corto') ?>',
                    maxlength: '<?php echo _('El Usuario es muy largo') ?>'
                },
                clave: {
                    required: '<?php echo _('Por favor ingrese una contraseña') ?>',
                    minlength: '<?php echo _('La Contraseña es muy corta') ?>',
                    maxlength: '<?php echo _('La Contraseña es muy larga') ?>'
                },
                re_clave: {
                    required: '<?php echo _('Por favor ingrese una contraseña') ?>',
                    equalTo: '<?php echo _('Las contraseñas deben coincidir') ?>'
                },
                nombre: {
                    required: '<?php echo _('Por favor ingrese el nombre') ?>',
                },
                apellido: {
                    required: '<?php echo _('Por favor ingrese el apellido ') ?>'
                },
                email: {
                    required: '<?php echo _('Por favor ingrese un email') ?>',
                    email: '<?php echo _('Por favor ingrese un email válido') ?>'
                },
                telefono: {
                    required: '<?php echo _('Por favor ingrese un teléfono') ?>'
                },
                dni: {
                    required: '<?php echo _('Por favor ingrese el DNI') ?>',
                    minlength: '<?php echo _('El DNI es muy corto. Debe ser de 8 caracteres, por ej.: 12346578') ?>',
                    maxlength: '<?php echo _('El DNI es muy largo. Debe ser de 10 caracteres, por ej.: 12345678') ?>'
                },
                tag: {
                    required: '<?php echo _('Por favor ingrese el TAG') ?>',
                    minlength: '<?php echo _('El TAG es muy corto. Debe ser de 10 caracteres, por ej.: 0000ABCDEF') ?>',
                    maxlength: '<?php echo _('El TAG es muy largo. Debe ser de 10 caracteres, por ej.: 0000ABCDEF') ?>'
                },
                equipo: {
                    required: '<?php echo _('Por favor seleccione un equipo') ?>'
                },
                usuario_tipo: {
                    required: '<?php echo _('Por favor seleccione un tipo de usuario') ?>'
                },
                te_celular: {
                    required: '<?php echo _('Por favor ingrese un teléfono') ?>'
                }
            },
            // Do not change code below
            errorPlacement: function (error, element) {
                error.insertAfter(element);
            }
        });
    });

    function setEliminarImagen(e) {
        $("#finalImg").attr("src", "img/avatars/male-big.png");
        $('#inputBorrarImagen').val('true');
        $('#btnEliminarImagen').remove();
    }


    $(document).ready(function () {
        $('#submit-editar').click(function () {
            var $form = $('#editar-form');
            if (!$('#editar-form').valid()) {
                return false;
            } else {
                //check
                $.ajax({
                    type: $form.attr('method'),
                    url: $form.attr('action'),
                    data: $form.serialize(),
                    success: function (data, status) {
                        $('#editar').modal('hide');
                        function refreshpage() {
                            $('#content').css({opacity: '0.0'}).html(data).delay(50).animate({opacity: '1.0'}, 300);
                            $('body').removeData('bs.modal');
                        }

                        setTimeout(refreshpage, 200);
                    }
                });
            }

        });

        $('body').on('hidden.bs.modal', '.modal', function () {
            $(this).removeData('bs.modal');
        });


    });


</script>
