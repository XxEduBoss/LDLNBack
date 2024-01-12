<?php


enum TipoNotificacion: int
{
    case Suscripcion = 0;
    case SubidaVideo = 1;
    case MensajeNuevo = 2;
    case Like = 3;
    case Comentario = 4;

}