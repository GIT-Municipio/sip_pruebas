-- Regresa un tramite un paso anterior cuando esta finalizado 
--update public.tbli_esq_plant_formunico_docsinternos set est_respuesta_recibido=1,est_respuesta_enviado=0,resp_estado_anterior='REASIGNADO'
--where ID=13922

--Muestra registros doc internos
--select * from public.tbli_esq_plant_formunico_docsinternos where num_memocreado=2104728

--Eliminar registro Doc internos
--delete from public.tbli_esq_plant_formunico_docsinternos where id=27122

-- Tramites Internos
--select * from plantillas.plantilla_999 where codigo_tramite='2104614'
--delete from plantillas.plantilla_999 where id=6087

--Tramites  externas
--select * from plantillas.plantilla_998 where codigo_tramite='2104728'
--delete from plantillas.plantilla_998 where id=5239


--Select * from public.tblb_org_departamento order by nombre_departamento
--select * from public.tblu_migra_usuarios where usu_departamento like '%PROD%'




