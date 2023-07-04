<?php
class Persona_ctrl{

    public $M_Persona =null;
    public function __construct(){
        $this->M_Persona=new M_Personas();

    }

    public function listarPersonas($f3){
        $cadenaSQL=" select * from persona ; ";
       // $items=$f3->BD->exec($cadenaSQL);
        $items=$f3->DB->exec($cadenaSQL);//solución al problema en clase
        //cambiar BD por DB
        echo json_encode(
        [
         'cantidad'=>count($items),
         'mensaje'=>count($items)>0? 'Consulta con Datos':'No existe datos',
         'datos'=>$items
        ]
    );
       
    }

    public function listarPersonasFatFree($f3){
        //$consulta=$this->M_Persona->find(["cedula=123"]);
        $consulta=$this->M_Persona->find();
        $items=array();
        foreach( $consulta as $persona){
            $items[]=$persona->cast();
        }

        echo json_encode(
        [
         'cantidad'=>count($items),
         'mensaje'=>count($items)>0? 'Consulta con Datos':'No existe datos',
         'datos'=>$items
        ]
    );
       
    }
   

    public function fun_buscarxCedula($f3){
         $pced=$f3->get('POST.micedula');
        /* echo "cedula:";
         echo  $pced;
         */
        $mensaje="";
        $persona=new M_Personas();
        $persona->load(['cedula=?',$pced]);
        $items=array();
        if($persona->loaded()>0){
            $mensaje="Persona encontrada";
            $items= $persona->cast();
        }else{
            $mensaje="NO existe la Persona buecada";
        }
        echo json_encode([
            'mensaje'=> $mensaje,
            'datos'=>$items
        ]);
      
 
     }

 public function fun_insertarPersona($f3){
     $mensaje="";
     $persona=new M_Personas();
     $persona->load(['cedula=?',$f3->get('POST.cedula')]);
     if( $persona->loaded()>0){
        $mensaje=" Ya existe una persona con esa cédula";
     }else{
        //insertar
        $this->M_Persona->set('cedula',$f3->get('POST.cedula'));
        $this->M_Persona->set('nombres',$f3->get('POST.nombres'));
        $this->M_Persona->set('apellidos',$f3->get('POST.apellidos'));
        $this->M_Persona->save();
        $mensaje=" Persona registrada con éxito";
     }
     echo json_encode([
        'mensaje'=>$mensaje
     ]);

 }


 public function fun_insertarPersonaSQL($f3){
    $cadenaSQL="";
    $cadenaSQL= $cadenaSQL. " insert into persona  ";
    $cadenaSQL= $cadenaSQL. " (cedula,nombres,apellidos) values (  ";
    $cadenaSQL= $cadenaSQL. " ' ".$f3->get('POST.cedula') ."', ";
    $cadenaSQL= $cadenaSQL. " ' ".$f3->get('POST.nombres') ."', ";
    $cadenaSQL= $cadenaSQL. " ' ".$f3->get('POST.apellidos') ."')";
     
        $items=$f3->DB->exec($cadenaSQL);//solución al problema en clase
        //cambiar BD por DB
        echo json_encode(
        [
        
         'mensaje'=>'SE regisró la persona',
     
        ]
    );

}

public function Actualizar($f3){
    $id=$f3->get('POST.cedula');
    $mensaje="";
    $this->M_Persona->load(['cedula=?', $id]);
    if($this->M_Persona->loaded()>0){
        $this->M_Persona->set('nombres',$f3->get('POST.nombres'));
        $this->M_Persona->set('apellidos',$f3->get('POST.apellidos'));
        $this->M_Persona->save();
        $mensaje="Persona Actualizado sus datos";
    }else{
        $mensaje="No existe la persona";
    }
    echo json_encode(
        [      
         'mensaje'=>$mensaje
        ]);
}

public function fun_eliminar($f3){
    $mensaje="";
    $id=$f3->get('POST.cedula');
    $this->M_Persona->load(['cedula=?', $id]);
    if($this->M_Persona->loaded()>0){
        $this->M_Persona->erase();
        $mensaje="Registro eliminado";
    }else{
        $mensaje="No existe el registro a eliminar";
    }
    echo json_encode(
        [      
         'mensaje'=>$mensaje
        ]);
}


}//fin clase
?>