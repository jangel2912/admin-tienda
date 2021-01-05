<!-- Note :
   - You can modify the font style and form style to suit your website. 
   - Code lines with comments ���Do not remove this code���  are required for the form to work properly, make sure that you do not remove these lines of code. 
   - The Mandatory check script can modified as to suit your business needs. 
   - It is important that you test the modified form before going live.-->
   <div id='crmWebToEntityForm' style='width:600px;margin:auto;display:none;'>
    <META HTTP-EQUIV ='content-type' CONTENT='text/html;charset=UTF-8'>
    <form action='https://crm.zoho.com/crm/WebToLeadForm' name=WebToLeads1498817000008916005 method='POST' onSubmit='javascript:document.charset="UTF-8"; return checkMandatory1498817000008916005()' accept-charset='UTF-8'>
  <input type='text' style='display:none;' name='xnQsjsdp' value='89e39294a1586b95b8e5e7463ac94012db9767427972e1172615746d811940cf'></input> 
  <input type='hidden' name='zc_gad' id='zc_gad' value=''></input> 
  <input type='text' style='display:none;' name='xmIwtLD' value='195689830b6ad271cd02e98e71c67fe34925b98bdebc8a030443f88b91a2f15f'></input> 
  <input type='text'  style='display:none;' name='actionType' value='TGVhZHM='></input>
  <input type='text' style='display:none;' name='returnURL' value='https://admintienda.vendty.com/crear-tienda' > </input><br></br>
      <!-- Do not remove this code. -->
     <style>
         #crmWebToEntityForm tr , #crmWebToEntityForm td { 
             padding:6px;
             border-spacing:0px;
             border-width:0px;
             }
     </style>
     <table style='width:600px;background-color:#ffffff;background-color:white;color:black'><tr><td colspan='2' align='left' style='color:black;font-family:Arial;font-size:14px;word-break: break-word;'><strong>Tienda2</strong></td></tr> <br></br><tr><td  style='word-break: break-word;text-align:left;font-size:12px;font-family:Arial;width:30%;'>Nombre</td><td style='width:40%;' ><input type='text' style='width:100%;box-sizing:border-box;'  maxlength='40' name='First Name' /></td><td style='width:30%;'></td></tr><tr><td  style='word-break: break-word;text-align:left;font-size:12px;font-family:Arial;width:30%;'>Apellidos<span style='color:red;'>*</span></td><td style='width:40%;' ><input type='text' style='width:100%;box-sizing:border-box;'  maxlength='80' name='Last Name' /></td><td style='width:30%;'></td></tr><tr><td  style='word-break: break-word;text-align:left;font-size:12px;font-family:Arial;width:30%;'>Correo electr&oacute;nico</td><td style='width:40%;' ><input type='text' style='width:100%;box-sizing:border-box;'  maxlength='100' name='Email' /></td><td style='width:30%;'></td></tr><tr><td  style='word-break: break-word;text-align:left;font-size:12px;font-family:Arial;width:30%;'>Tel&eacute;fono</td><td style='width:40%;' ><input type='text' style='width:100%;box-sizing:border-box;'  maxlength='30' name='Phone' /></td><td style='width:30%;'></td></tr><tr><td  style='word-break: break-word;text-align:left;font-size:12px;font-family:Arial;width:30%;'>Empresa</td><td style='width:40%;' ><input type='text' style='width:100%;box-sizing:border-box;'  maxlength='100' name='Company' /></td><td style='width:30%;'></td></tr><tr style='display:none;' ><td style='word-break: break-word;text-align:left;font-size:12px;font-family:Arial;width:30%'>Tipo Negocio 2</td><td style='width:40%;'>
         <select style='width:100%;box-sizing:border-box;' name='LEADCF6'>
             <option value='-None-'>-None-</option>
             <option value='Retail'>Retail</option>
             <option value='Restaurante'>Restaurante</option>
         <option selected value='Tienda'>Tienda</option>
             <option value='Moda'>Moda</option>
         </select></td><td style='width:30%;'></td></tr><tr style='display:none;' ><td style='word-break: break-word;text-align:left;font-size:12px;font-family:Arial;width:30%'>Fuente 3</td><td style='width:40%;' ><input type='text' style='width:100%;box-sizing:border-box;'  maxlength='255' name='LEADCF3' value='registro'></input></td><td style='width:30%;'></td></tr><tr><td  style='word-break: break-word;text-align:left;font-size:12px;font-family:Arial;width:30%;'>Aliado</td><td style='width:40%;' ><input type='text' style='width:100%;box-sizing:border-box;'  maxlength='255' name='LEADCF7' /></td><td style='width:30%;'></td></tr>
 
     <tr><td colspan='2' style='text-align:center; padding-top:15px;font-size:12px;'>
         <input style='margin-right: 5px;cursor: pointer;font-size:12px;color:#000000' id='formsubmit' type='submit' value='Enviar'  ></input> <input type='reset' name='reset' style='cursor: pointer;font-size:12px;color:#000000' value='Restablecer' ></input> </td></tr></table>
     <script>
        var mndFileds=new Array('Last Name');
        var fldLangVal=new Array('Apellidos'); 
         var name='';
         var email='';
 
        function checkMandatory1498817000008916005() {
         for(i=0;i<mndFileds.length;i++) {
           var fieldObj=document.forms['WebToLeads1498817000008916005'][mndFileds[i]];
           if(fieldObj) {
             if (((fieldObj.value).replace(/^\s+|\s+$/g, '')).length==0) {
              if(fieldObj.type =='file')
                 { 
                  alert('Seleccione un archivo para cargar.'); 
                  fieldObj.focus(); 
                  return false;
                 } 
             alert(fldLangVal[i] +' no puede estar vacío.'); 
                       fieldObj.focus();
                       return false;
             }  else if(fieldObj.nodeName=='SELECT') {
                      if(fieldObj.options[fieldObj.selectedIndex].value=='-None-') {
                 alert(fldLangVal[i] +' no puede ser nulo.'); 
                 fieldObj.focus();
                 return false;
                }
             } else if(fieldObj.type =='checkbox'){
                 if(fieldObj.checked == false){
                 alert('Please accept  '+fldLangVal[i]);
                 fieldObj.focus();
                 return false;
                } 
              } 
              try {
                  if(fieldObj.name == 'Last Name') {
                 name = fieldObj.value;
                    }
             } catch (e) {}
             }
         }
         document.getElementById('formsubmit').disabled=true;
     }
 </script>
     </form>
 </div>