<?php

namespace App\Traits;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Empresa;
use Mail;

trait CheckLicenciaSysClockTrait
{
 
  
    public function ChequeoLicencia(){
          $now = date("d-m-Y");
          $Recordatorio = ajuste('send_mail_license');

          if($Recordatorio == 'S'){
              $sql = DB::table('pagos')->select('*')->get();
              $registros = collect($sql);

              foreach($registros as $registro){
                  $vencimiento = date_format(date_create($registro->pago_fvencimiento), 'd-m-Y');

                  $dif_dias = Carbon::parse($vencimiento)->diffInDays(Carbon::parse($now));
                  $empresa = Empresa::where('empresa_estado','1')->first();

                  if($dif_dias <= 7 && $registro->pago_prox_mail == null){
                    
                      $fecha_det = explode('-', $vencimiento);

                      $data = array('vencimiento_dia' => $fecha_det[0], 'vencimiento_mes' => $fecha_det[1], 'empresa' => $empresa->empresa_nombre); 

                      Mail::send('common.mail', $data, function($message) use ($empresa){
                          if($empresa->empresa_email2 == null){
                              if($empresa->empresa_email != null){
                                  $message->to($empresa->empresa_email)->bcc('matiasfiermarin@hotmail.com')->bcc('Fede.santucho@hotmail.com')->subject('Recordatorio de vencimiento');
                              }
                          }else{
                              $message->to($empresa->empresa_email)->cc($empresa->empresa_email2)->bcc('matiasfiermarin@hotmail.com')->bcc('Fede.santucho@hotmail.com')->subject('Recordatorio de vencimiento');
                          }
                      });

                      $fecha_nueva = date("d-m-Y",strtotime($vencimiento."- 1 days")); 

                      $Update = DB::update('UPDATE pagos SET pago_prox_mail = ? WHERE id= ?',[$fecha_nueva, $registro->id]);
                  }elseif($dif_dias == 1){
                      $fecha_det = explode('-', $vencimiento);

                      if($registro->pago_prox_mail != '01-01-1999'){
                          $data = array('vencimiento_dia' => $fecha_det[0], 'vencimiento_mes' => $fecha_det[1], 'empresa' => $empresa->empresa_nombre); 

                          Mail::send('common.mail_vencido', $data, function($message) use ($empresa){
                             if($empresa->empresa_email2 == null){
                                  if($empresa->empresa_email != null){
                                      $message->to($empresa->empresa_email)->bcc('matiasfiermarin@hotmail.com')->bcc('Fede.santucho@hotmail.com')->subject('Recordatorio de vencimiento');
                                  }
                              }else{
                                  $message->to($empresa->empresa_email)->cc($empresa->empresa_email2)->bcc('matiasfiermarin@hotmail.com')->bcc('Fede.santucho@hotmail.com')->subject('Recordatorio de vencimiento');
                              }
                          });

                          $fecha_nueva = date("d-m-Y",strtotime($now."+ 6 days")); 

                          $Update = DB::update('UPDATE pagos SET pago_prox_mail = ? WHERE id= ?',['01-01-1999', $registro->id]);
                      }
                  }
              }
          }
      } // FIN FUNCTION ChequeoLicencia
  
  
  
} //FIN CLASE