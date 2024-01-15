drop table if exists valoracion_negativa;
drop table if exists valoracion_positiva;
drop table if exists comentario;
drop table if exists visita;
drop table if exists notificacion;
drop table if exists token;
drop table if exists mensaje;
drop table if exists suscripcion;
drop table if exists video;
drop table if exists canal;
drop table if exists usuario;


create table usuario (

                         id serial,

                         username varchar(50) unique not null,

                         password varchar(1000) not null,

                         rol_usuario int not null,

                         activo bool default true not null,

                         primary key (id)

);

create table canal(
                      id serial,
                      nombre varchar(100) not null,
                      apellidos varchar(100),
                      nombre_canal varchar(100),
                      telefono varchar(10),
                      fecha_nacimiento timestamp(6) not null,
                      fecha_creacion timestamp(6) not null,
                      etiquetas int,
                      usuario int not null,

                      primary key (id),
                      constraint fk_canal_usuario foreign key (usuario) references usuario(id)

);

create table video(
                      id serial,
                      titulo varchar(100) not null,
                      descripcion varchar(500),
                      url varchar(10000),
                      etiquetas int not null,
                      fecha_publicacion timestamp(6) not null,
                      fecha_creacion timestamp(6) not null,
                      canal int not null,

                      primary key (id),
                      constraint fk_video_canal foreign key (canal) references canal(id)

);


create table suscripcion(
                            id serial,
                            fecha_suscripcion timestamp(6) not null,
                            canal int not null,
                            usuario int not null,

                            primary key (id),
                            constraint fk_suscripcion_usuario foreign key (usuario) references usuario(id),
                            constraint fk_suscripcion_canal foreign key (canal) references canal(id)

);

create table mensaje(
                        id serial,
                        texto varchar(10000) not null,
                        fecha_envio timestamp(6) not null,
                        usuario_emisor int not null,
                        usuario_receptor int not null,

                        primary key (id),
                        constraint fk_mensaje_emisor foreign key (usuario_emisor) references usuario(id),
                        constraint fk_mensaje_receptor foreign key (usuario_receptor) references usuario (id)

);

create table token(
                      id serial,
                      apikey varchar(10000) not null,
                      fecha_expedicion timestamp(6) not null,
                      fecha_creacion timestamp(6) not null,
                      usuario int not null,

                      primary key (id),
                      constraint fk_token_usuario foreign key (usuario) references usuario(id)

);

create table notificacion(
                             id serial,
                             texto varchar(10000) not null,
                             tipo int not null,
                             fecha_notificacion timestamp(6) not null,
                             usuario int not null,

                             primary key (id),
                             constraint fk_notificacion_usuario foreign key (usuario) references usuario(id)

);

create table visita(
                       id serial,
                       fecha_visita timestamp(6) not null,
                       video int not null,
                       usuario int not null,

                       primary key (id),
                       constraint fk_visita_usuario foreign key (usuario) references usuario(id),
                       constraint fk_visita_video foreign key (video) references video(id)

);

create table comentario(
                           id serial,
                           texto varchar(10000) not null,
                           fecha_publicacion timestamp(6) not null,
                           video int not null,
                           usuario int not null,

                           primary key (id),
                           constraint fk_comentario_usuario foreign key (usuario) references usuario(id),
                           constraint fk_comentario_video foreign key (video) references video(id)

);

create table valoracion_positiva(
                                    id serial,
                                    likes boolean,
                                    video int not null,
                                    usuario int not null,

                                    primary key (id),
                                    constraint fk_like_usuario foreign key (usuario) references usuario(id),
                                    constraint fk_like_video foreign key (video) references video(id)

);

create table valoracion_negativa(
                                    id serial,
                                    dislikes boolean,
                                    video int not null,
                                    usuario int not null,

                                    primary key (id),
                                    constraint fk_dislike_usuario foreign key (usuario) references usuario(id),
                                    constraint fk_dislike_video foreign key (video) references video(id)

);