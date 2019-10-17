@php
    // La funcion ajuste y formatFecha estan en el archivo app/http/helper.php
    
    $logo = ajuste('system_logo');
    $empresa = ajuste('company_name');
    
@endphp
<!DOCTYPE html PUBLIC>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>REPORTE DE MARCAS EN EL DIA DE AYER</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>
    <body style="margin: 0; padding: 0;">
    	<table border="0" cellpadding="0" cellspacing="0" width="100%">	
    		<tr>
    			<td style="padding: 10px 0 30px 0;">
    				<table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border: 1px solid #cccccc; border-collapse: collapse;">
    					<tr>
    						<td align="center" bgcolor="#ffffff" style="padding: 40px 0 30px 0; color: #153643; font-size: 28px; font-weight: bold; font-family: Arial, sans-serif;">
    							<img src="{{ asset('images/'. $logo) }}" alt="Creating Email Magic" width="400" height="100" style="display: block;" />
    						</td>
    					</tr>
    					<tr>
    						<td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
    							<table border="0" cellpadding="0" cellspacing="0" width="100%">
    								<tr>
    									<td style="color: #153643; font-family: Arial, sans-serif; font-size: 24px;">
    										<b>Reporte - Marcas de horas del dia de ayer @php echo date('Y-m-d', strtotime('yesterday')); @endphp </b>
    									</td>
    								</tr>
    								<tr>
    									<td style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
    										Estimado cliente @php echo $empresa @endphp, el presente correo se le envía con el fin de informarle las marcas de los empleados ingresaron o no en el de dia de ayer @php echo date('Y-m-d', strtotime('yesterday')); @endphp
                                            <br><br>
                                            Atentamente<br>
                                            Equipo de SysClock.
    									</td>
    								</tr>
    							</table>
    						</td>
    					</tr>
    					<tr>
    						<td bgcolor="#ee4c50" style="padding: 30px 30px 30px 30px;">
    							<table border="0" cellpadding="0" cellspacing="0" width="100%">
    								<tr>
    									<td style="color: #ffffff; font-family: Arial, sans-serif; font-size: 14px;" width="75%">
    										&reg; Todos los derechos reservados, 2019<br/>
    									</td>
    									<td align="right" width="25%">
    										<table border="0" cellpadding="0" cellspacing="0">
    											<tr>
    												<td style="font-family: Arial, sans-serif; font-size: 12px; font-weight: bold;">
    													<a href="#" style="color: #ffffff;">
    														<img src="https://png.pngtree.com/element_our/md/20180301/md_5a9797d302f17.png" alt="Twitter" width="50" height="50" style="display: block;" border="0" />
    													</a>
    												</td>
    												<td style="font-size: 0; line-height: 0;" width="20">&nbsp;</td>
    												<td style="font-family: Arial, sans-serif; font-size: 12px; font-weight: bold;">
    													<a href="#" style="color: #ffffff;">
    														<img src="https://cdn.icon-icons.com/icons2/1211/PNG/512/1491579586-yumminkysocialmedia21_83091.png" alt="Facebook" width="38" height="38" style="display: block;" border="0" />
    													</a>
    												</td>
    											</tr>
    										</table>
    									</td>
    								</tr>
    							</table>
    						</td>
    					</tr>
    				</table>
    			</td>
    		</tr>
    	</table>
    </body>
</html>