<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Reporte Encuestas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="<?php echo base_url();?>assets/ico/favicon.png">
    <link href="<?php echo base_url();?>assets/css/bootstrap.css" rel="stylesheet" media="screen">
    <link href="<?php echo base_url();?>assets/css/custom_fischman.css" rel="stylesheet">  
    <link href="<?php echo base_url();?>assets/css/font.css" rel="stylesheet">  

    <link href="<?php echo base_url();?>assets/css/sticky-footer-navbar.css" rel="stylesheet">  
    <link href="<?php echo base_url();?>assets/css/styles.css" rel="stylesheet">
    <!--[if lt IE 9]>
      <script src="<?php echo base_url();?>/assets/js/html5shiv.js"></script>
      <script src="<?php echo base_url();?>/assets/js/respond.min.js"></script>

    <![endif]-->
    <script src="<?php echo base_url();?>/assets/js/jquery3.min.js"></script>
    <script src="<?php echo base_url();?>/assets/js/jszip.min.js"></script>
    <script src="<?php echo base_url();?>/assets/js/jszip-utils.min.js"></script>
    <script src="<?php echo base_url();?>/assets/js/filesaver.js"></script>
    <script src="<?php echo base_url();?>/assets/js/download.js"></script>
    <?php if (isset($head_content)) echo $head_content; ?>

	<style type="text/css">

	::selection{ background-color: #E13300; color: white; }
	::moz-selection{ background-color: #E13300; color: white; }
	::webkit-selection{ background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body{
		margin: 0 15px 0 15px;
	}
	
	p.footer{
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}
	
	#container{
		margin: 10px;
		border: 1px solid #D0D0D0;
		-webkit-box-shadow: 0 0 8px #D0D0D0;
	}
    
    .error{
        color: red;
        font-size: 13px;
        margin-bottom: -15px;
    }

    #loading {
        background: url('<?php echo base_url();?>assets/images/ajax-loader.gif') no-repeat center center;
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
        z-index: 9999999;
        display: none;
    }

    .alert {
        padding: 10px;
        background-color: #a95151;
        color: white;
        margin-bottom: 10px;
        font-size: 16px;
        text-align: center;
    }

    .closebtn {
        margin-left: 15px;
        color: white;
        font-weight: bold;
        float: right;
        font-size: 22px;
        line-height: 20px;
        cursor: pointer;
        transition: 0.3s;
    }

    /* When moving the mouse over the close button */
    .closebtn:hover {
        color: black;
    }

    .bGreen{
        background-color: green;
    }

    .bBlue{
        background-color: blue;
    }
	</style>
</head>
<body>

<div id="content">
    <div class="contentTop clearfix">
        <span class="pageTitle">
        <span class="icon-screen"></span>Reporte Encuestas</span>
    </div>
    <!-- contentTop -->
        
    <div class="breadLine">
        <div class="bc">
            <ul class="breadcrumbs" id="breadcrumbs">
                <li><a href="#">Reportes</a></li>
                <li class="current"><a href="#">Seguimiento encuestas</a></li>
            </ul>
        </div>
    </div>
    <!-- Breadcrumbs line -->
    <!-- Main content -->
    <div class="wrapper">
        <!-- <div class="fluid">
            <div class="titleTwoLevel">
                <span class="icos-cog4"></span><h5>Seguimiento Encuestas</h5>
            </div>
       -->
<div class="dashboard dataList crud">

    <div class="widget tableDefault containerReport clearfix">
  
        <div class="whead clearfix">
            <h6>LINKS DE ENCUESTAS</h6>
        </div>

        <div id="loading"></div>
          
        <div class="formCrudCreate">

            <div class="alert hide">
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                ¡Esto puede tardar varios minutos!
            </div>
            
            <form class="crudBenchmarking main" method="post" action="welcome" novalidate="novalidate">
            
                <div class="fluid tableDefault clearfix">
                        
                    <fieldset style="display: block;" id="w1first" class="step ui-formwizard-content clearfix">
                        
                        <div class="grid12">
                            
                            <div class="formRow clearfix">
                                <div class="grid2"><label>Empresa</label><span class="req">*</span></div>
                                <div class="grid6">
                                    <div class="selector" id="uniform-options_company">
                                        <span style="-moz-user-select: none;"><?php echo $institucion_s;?></span>
                                    <?php 
                                    $js['institucion'] = 'id="institucion" onChange="this.form.submit();"';
                                    echo form_dropdown('institucion', $institucion, $institucion_s, $js['institucion']); 
                                    ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="formRow clearfix">
                                <div class="grid2"><label>Intereses</label><span class="req">*</span></div>
                                <div class="grid6 pollschedulingsByPoll">
                                    <div class="selector" id="uniform-options_pollscheduling">
                                        <span style="-moz-user-select: none;"><?php echo $pollintereses_s;?></span>
                                    <?php 
                                    $js['pollintereses'] = 'id="pollintereses" onChange="this.form.submit();"';
                                    echo form_dropdown('pollintereses', $pollintereses, $pollintereses_s, $js['pollintereses']); 
                                    ?>
                                    </div>
                                </div>
                            </div>


                            <div class="formRow clearfix">
                                <div class="grid2"><label>Temperamentos</label><span class="req">*</span></div>
                                <div class="grid6 pollschedulingsByPoll">
                                    <div class="selector" id="uniform-options_pollscheduling_t">
                                        <span style="-moz-user-select: none;"><?php echo $polltemperamentos_s;?></span>
                                    <?php 
                                    $js['polltemperamentos'] = 'id="polltemperamentos" onChange="this.form.submit();"';
                                    echo form_dropdown('polltemperamentos', $polltemperamentos, $polltemperamentos_s, $js['polltemperamentos']); 
                                    ?>
                                    </div>
                                </div>
                            </div>
                            
                            
                        </div>
                        
                    </fieldset>
                    
                </div>
                <!-- /.tableDefault -->
                
                <div class="reportDashboardButton menuCrud clearfix">
                    <ul class="record_actions">

                        <li><button class="sideB bGreen mt10 spanButton" type="submit" name="generate_report" value="zip">Excel Status</button></li>

                        <li><button class="sideB bBlue mt10 spanButton" onclick="getZip()" type="button" name="generate_report">Exportar Pdfs</button></li>
                        
                        <li><button class="autoselectOptionData2 sideB bGreyish mt10" value="report" name="generate_report" type="submit">Generar Reporte</button></li>
                        <!--li><a class="sideB bRed mt10 spanButton" href="<?php echo site_url('welcome/excel') ?>">Exportar a Excel</a></li-->
                        <li><button class="sideB bRed mt10 spanButton" type="submit" name="generate_report" value="excel">Exportar links individuales</button></li>

                        <li><button class="sideB bRed mt10 spanButton" type="submit" name="generate_report" value="consolidado">Exportar Consolidado individuales</button></li>

                        <li><button class="sideB bRed mt10 spanButton" value="general" name="generate_report" type="submit"> 
                        Exportar Consolidado Empresa</button></li>
                        
                    </ul>
                </div>
                <!-- /.menuCrud -->
                
            </form>
            <div class="progress hide" id="progress_bar">
                <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                </div>
            </div>
        </div>
        <!-- /.formCrudCreate -->

    </div>
    <!-- /.tableDefault -->
    
    <?php if (count($reporte)) {?>
    
    <div class="widget tableDefault clearfix">
        <div class="dataListTable">
            <table class="records_list dataTable">
                <thead>
                    <tr>
                        <th>NOMBRE</th>
                        <th>INTERESES</th>
                        <th>TALENTOS</th>
                        <th>TEMPERAMENTOS</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                foreach ($reporte as $row) {
                    echo "<tr>
                        <td>". $row->name . "</td>
                        <td>". $row->intereses . "</td>
                        <td>". $row->talentos . "</td>
                        <td>". $row->temperamentos . "</td>

                    </tr>";
                }
                ?>
                    
                </tbody>
            </table>
        </div>
    </div>
    
    <?php } ?>
    
    
</div>
<!-- /.dataList -->

        </div>
    </div>
    <!-- Main content ends -->
</div>

<script type="text/javascript">
    var Promise = window.Promise;
    if (!Promise) {
        Promise = JSZip.external.Promise;
    }
    $(function() {
        var a = document.getElementById("descarga");
        function cutAndPaste(from, to) {
            $(to).append(function() {
                return $(from + " option:selected").each(function() {
                    this.outerHTML;
                }).remove();
            });
        }

        $("#forward").off("click").on("click", function() {
            cutAndPaste("#evaluados", "#seleccionados");
        });

        $("#backward").off("click").on("click", function() {
            cutAndPaste("#seleccionados", "#evaluados");
        });
    });
    
    function getZip() {
        var poll = $('#pollintereses').val();
        poll = poll.split('-');
        poll = poll[0].trim();
        $('#loading').show();
        $('.alert').show();
        $.ajax({
            url: '<?php echo base_url();?>index.php/welcome/getLinksConsolidadoJson/'+poll,
            type: "GET",
            dataType: "json",
            success: function (d) {
                generateZIP(d);
            },
            error: function (error) {
                console.log(`Error ${error}`);
            }
        });
    }

    function generateZIP(links) {
        var zip = new JSZip();
        var count = 0;
        var zipFilename = "rep.zip";

        load(links);
        /*links.forEach((url, i) => {
            JSZipUtils.getBinaryContent(url.consolidado, function (err, data) {
                if (err) {
                    console.log(err);
                }
                zip.file(url.name+'.pdf', data, { binary: true });
                count++;
                if (count == links.length) {
                    zip.generateAsync({ type: 'blob' }).then(function (content) {
                        $('#loading').hide();
                        saveAs(content, zipFilename);
                    });
                }
            });
        });*/
        /*links.forEach(function (url, i) {
            $.ajax({
                url: url.consolidado,
                xhrFields:{
                    responseType: 'blob'
                },
                success: (data) => {
                    let blob = new Blob([data], {type: 'arraybuffer'});
                    let link = document.createElement('a');
                    let objectURL = window.URL.createObjectURL(blob);
                    link.href = objectURL;
                    link.target = '_self';
                    link.download = url.name+'.pdf';
                    (document.body || document.documentElement).appendChild(link);
                    link.click();
                }
            });
        });*/
        /*var filename = links[0].name + '.pdf';
        $.ajax({
            url: links[0].consolidado,
            xhrFields:{
                responseType: 'blob'
            },
            success: (data) => {
                let blob = new Blob([data], {type: 'arraybuffer'});
                let link = document.createElement('a');
                let objectURL = window.URL.createObjectURL(blob);
                link.href = objectURL;
                link.target = '_self';
                link.download = "fileName.pdf";
                (document.body || document.documentElement).appendChild(link);
                link.click();
            }
        });*/
        /* var req = new XMLHttpRequest();
        req.open("GET", links[0].consolidado, true);
        req.responseType = "blob";

        req.onload = function (event) {
            var blob = req.response;
            console.log(blob.size);
            var link=document.createElement('a');
            link.href=window.URL.createObjectURL(blob);
            link.download="Dossier_" + new Date() + ".pdf";
            link.click();
        };

        req.send();*/
    }

    async function load(links) {
        for (let index = 0; index < links.length; index++){
            //window.open(links[index].consolidado,'_blank');
            const file = await getNumFruit(links[index]);
            //zip.file(links[index].name+'.pdf', file);
        }
    }

    const sleep = ms => {
        return new Promise(resolve => setTimeout(resolve, ms))
    };

    const getNumFruit = (url) => {  $('#loading').show();
        return sleep(25000).then(v => { console.log('odlir', url);
            $.ajax({
                url: url.consolidado,
                xhrFields:{
                    responseType: 'blob'
                },
                success: (data) => {
                    let blob = new Blob([data], {type: 'arraybuffer'});
                    let link = document.createElement('a');
                    let objectURL = window.URL.createObjectURL(blob);
                    link.href = objectURL;
                    link.target = '_self';
                    link.download = url.name+'.pdf';
                    (document.body || document.documentElement).appendChild(link);
                    link.click();
                    $('#loading').hide();
                }
            });
        })
    };


</script>

</body>
</html>