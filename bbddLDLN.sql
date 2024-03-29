drop table if exists reset_password_request;
drop table if exists etiquetas_video;
drop table if exists etiquetas_canal;
drop table if exists etiquetas_usuario;
drop table if exists etiquetas;
drop table if exists valoracion_negativa;
drop table if exists valoracion_positiva;
drop table if exists comentario;
drop table if exists visita;
drop table if exists notificacion;
drop table if exists tipo_notificacion;
drop table if exists token;
drop table if exists mensaje;
drop table if exists suscripcion;
drop table if exists video;
drop table if exists tipo_video;
drop table if exists canal;
drop table if exists historial_busqueda;
drop table if exists usuario;
drop table if exists rol_usuario;


create table rol_usuario(
                          id serial,
                          rol varchar(1000) not null,
                          primary key (id)
);

insert into rol_usuario(rol) values ('ADMIN'),
                                    ('USUARIO');

create table usuario (
                         id serial,
                         username varchar(50) unique not null,
                         password varchar(1000) not null,
                         id_rol_usuario int not null,
                         comunidad_autonoma varchar(50) not null ,
                         foto varchar(10000) not null,
                         activo bool default true not null,
                         primary key (id),
                         constraint fk_usuario_rol foreign key (id_rol_usuario) references rol_usuario(id)
);

create table historial_busqueda (
                         id serial,
                         texto varchar(100000) unique not null,
                         fecha_busqueda timestamp(6) not null,
                         id_usuario int not null,
                         activo bool default true not null,
                         primary key (id),
                         constraint fk_usuario_busqueda foreign key (id_usuario) references usuario(id)
);

create table canal(
                      id serial,
                      nombre varchar(100) not null,
                      apellidos varchar(100),
                      nombre_canal varchar(100),
                      telefono varchar(10),
                      fecha_nacimiento timestamp(6) not null,
                      fecha_creacion timestamp(6) not null,
                      banner varchar(10000) not null,
                      id_usuario int not null,
                      activo bool default true not null,

                      primary key (id),
                      constraint fk_canal_usuario foreign key (id_usuario) references usuario(id)

);

create table tipo_video(
                           id serial,
                           descripcion varchar(1000) not null,
                           primary key (id)
);

create table video(
                      id serial,
                      titulo varchar(100) not null,
                      descripcion varchar(5000),
                      url varchar(10000),
                      id_tipo_video int not null,
                      fecha_publicacion timestamp(6) not null,
                      fecha_creacion timestamp(6) not null,
                      activo bool default true not null,
                      miniatura varchar(10000) not null,
                      id_canal int not null,

                      primary key (id),
                      constraint fk_video_canal foreign key (id_canal) references canal(id),
                      constraint fk_video_tipo foreign key (id_tipo_video) references tipo_video(id)

);


create table suscripcion(
                            id serial,
                            fecha_suscripcion timestamp(6) not null,
                            activo bool default true not null,
                            id_canal int not null,
                            id_usuario int not null,

                            primary key (id),
                            constraint fk_suscripcion_usuario foreign key (id_usuario) references usuario(id),
                            constraint fk_suscripcion_canal foreign key (id_canal) references canal(id)

);

create table mensaje(
                        id serial,
                        texto varchar(10000) not null,
                        fecha_envio timestamp(6) not null,
                        activo bool default true not null,
                        leido bool default false not null ,
                        id_canal_emisor int not null,
                        id_canal_receptor int not null,

                        primary key (id),
                        constraint id_canal_emisor foreign key (id_canal_emisor) references canal(id),
                        constraint id_canal_receptor foreign key (id_canal_receptor) references canal (id)

);

create table token(
                      id serial,
                      apikey varchar(10000) not null,
                      fecha_expedicion timestamp(6) not null,
                      fecha_creacion timestamp(6) not null,
                      activo bool default true not null,
                      id_usuario int not null,

                      primary key (id),
                      constraint fk_token_usuario foreign key (id_usuario) references usuario(id)

);

create table tipo_notificacion(
                                  id serial,
                                  descripcion varchar(1000) not null,
                                  primary key (id)
);

create table notificacion(
                             id serial,
                             texto varchar(10000) not null,
                             id_tipo_notificacion int not null,
                             fecha_notificacion timestamp(6) not null,
                             activo bool default true not null,
                             id_usuario int not null,

                             primary key (id),
                             constraint fk_notificacion_usuario foreign key (id_usuario) references usuario(id),
                             constraint fk_notificacion_tipo foreign key (id_tipo_notificacion) references tipo_notificacion(id)

);

create table visita(
                       id serial,
                       fecha_visita timestamp(6) not null,
                       activo bool default true not null,
                       id_video int not null,
                       id_usuario int not null,

                       primary key (id),
                       constraint fk_visita_usuario foreign key (id_usuario) references usuario(id),
                       constraint fk_visita_video foreign key (id_video) references video(id)

);

create table comentario(
                           id serial,
                           texto varchar(10000) not null,
                           fecha_publicacion timestamp(6) not null,
                           activo bool default true not null,
                           id_video int not null,
                           id_usuario int not null,

                           primary key (id),
                           constraint fk_comentario_usuario foreign key (id_usuario) references usuario(id),
                           constraint fk_comentario_video foreign key (id_video) references video(id)

);

create table valoracion_positiva(
                                    id serial,
                                    likes boolean,
                                    activo bool default true not null,
                                    id_video int not null,
                                    id_usuario int not null,

                                    primary key (id),
                                    constraint fk_like_usuario foreign key (id_usuario) references usuario(id),
                                    constraint fk_like_video foreign key (id_video) references video(id)

);

create table valoracion_negativa(
                                    id serial,
                                    dislikes boolean,
                                    activo bool default true not null,
                                    id_video int not null,
                                    id_usuario int not null,

                                    primary key (id),
                                    constraint fk_dislike_usuario foreign key (id_usuario) references usuario(id),
                                    constraint fk_dislike_video foreign key (id_video) references video(id)

);

create table etiquetas(
                                  id serial,
                                  descripcion varchar(1000) not null,
                                  primary key (id)
);

create table etiquetas_video(
                                  id_etiqueta int not null,
                                  id_video int not null,
                                  constraint fk_etiquetas_video_etiquetas foreign key (id_etiqueta) references etiquetas(id),
                                  constraint fk_etiquetas_video_video foreign key (id_video) references video(id)
);

create table etiquetas_canal(
                                  id_etiqueta int not null,
                                  id_canal int not null,
                                  constraint fk_etiquetas_canal_etiquetas foreign key (id_etiqueta) references etiquetas(id),
                                  constraint fk_etiquetas_canal_canal foreign key (id_canal) references canal(id)
);

create table etiquetas_usuario(
                                  id_etiqueta int not null,
                                  id_usuario int not null,
                                  constraint fk_etiquetas_usuario_etiquetas foreign key (id_etiqueta) references etiquetas(id),
                                  constraint fk_etiquetas_usuario_usuario foreign key (id_usuario) references usuario(id)
);

CREATE TABLE reset_password_request (
                                        id SERIAL PRIMARY KEY,
                                        id_usuario INT NOT NULL,
                                        expires_at TIMESTAMP NOT NULL,
                                        selector VARCHAR(255) NOT NULL,
                                        hashed_token VARCHAR(255) NOT NULL
);


insert into tipo_notificacion(descripcion) values ('SUBIDA VIDEO'),
                                                  ('SUSCRIPCION'),
                                                  ('MENSAJE NUEVO'),
                                                  ('COMENTARIO NUEVO'),
                                                  ('LIKE');

insert into tipo_video(descripcion) values ('PUBLICO'),
                                           ('OCULTO'),
                                           ('PRIVADO'),
                                           ('SUSCRITO');

insert into etiquetas(descripcion) values ('PROGRAMACIÓN'),
                                          ('EDUCACIÓN'),
                                          ('VIAJES'),
                                          ('COCINA'),
                                          ('EJERCICIO'),
                                          ('ENTRETENIMIENTO'),
                                          ('CIENCIA'),
                                          ('MÚSICA'),
                                          ('CINE'),
                                          ('VIDEOJUEGOS'),
                                          ('MODA'),
                                          ('NOTICIAS'),
                                          ('ANIMALES');

drop table apollo.mensaje;

ALTER TABLE canal
    ALTER COLUMN banner SET NOT NULL;
alter table reset_password_request

add column requested_at TIMESTAMP NOT NULL; -- Agregar esta línea




