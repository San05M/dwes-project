<?php

use dwes\app\entity\Imagen;
use dwes\app\utils\File;
use dwes\app\exceptions\FileException;
use dwes\core\helpers\FlashMessage;
use dwes\app\repository\ImagenesRepository;
use dwes\app\repository\CategoriasRepository;
use dwes\core\App;
use dwes\app\exceptions\QueryException;
use dwes\app\exceptions\AppException;
use dwes\app\exceptions\CategoriaException;
use dwes\app\exceptions\ValidationException;
use dwes\core\Response;


class GaleriaController
{
    public function index()
    {

        $errores = FlashMessage::get('errores', []);
        $mensaje = FlashMessage::get('mensaje');
        $descripcion = FlashMessage::get('descripcion');
        $categoriaSeleccionada = FlashMessage::get('categoriaSeleccionada');
        $titulo = FlashMessage::get('titulo');

        try {
            $imagenes = App::getRepository(ImagenesRepository::class)->findAll();
            $categorias = App::getRepository(CategoriasRepository::class)->findAll();
        } catch (QueryException $queryException) {
            FlashMessage::set('errores', [$queryException->getMessage()]);
        } catch (AppException $appException) {
            FlashMessage::set('errores', [$appException->getMessage()]);
        }

        Response::renderView(
            'galeria',
            'layout',
            compact('imagenes', 'categorias', 'errores', 'titulo', 'descripcion', 'mensaje', 'categoriaSeleccionada')
        );
    }

    public function nueva()
    {
        try {
            $imagenesRepository = App::getRepository(ImagenesRepository::class);

            $titulo = trim(htmlspecialchars($_POST['titulo']));
            FlashMessage::set('titulo', $titulo);

            $descripcion = trim(htmlspecialchars($_POST['descripcion']));
            FlashMessage::set('descripcion', $descripcion);

            $categoria = trim(htmlspecialchars($_POST['categoria']));
            if (empty($categoria)) {
                throw new CategoriaException;
            }
            FlashMessage::set('categoriaSeleccionada', $categoria);

            $tiposAceptados = ['image/jpeg', 'image/gif', 'image/png'];
            $imagen = new File('imagen', $tiposAceptados);

            $imagen->saveUploadFile(Imagen::RUTA_IMAGENES_SUBIDAS);

            $imagenGaleria = new Imagen($imagen->getFileName(), $descripcion, $categoria);
            $imagenesRepository->save($imagenGaleria);

            $mensaje = "Se ha guardado una imagen: " . $imagenGaleria->getTitulo();

            App::get('logger')->add($mensaje);
            FlashMessage::set('mensaje', $mensaje);

            FlashMessage::unset('descripcion');
            FlashMessage::unset('categoriaSeleccionada');
            FlashMessage::unset('titulo');

        } catch (ValidationException $validationException) {
            FlashMessage::set('errores', [$validationException->getMessage()]);
        } catch (FileException $fileException) {
            FlashMessage::set('errores', [$fileException->getMessage()]);
        } catch (QueryException $queryException) {
            FlashMessage::set('errores', [$queryException->getMessage()]);
        } catch (AppException $appException) {
            FlashMessage::set('errores', [$appException->getMessage()]);
        } catch (CategoriaException) {
            FlashMessage::set('errores', ["No se ha seleccionado una categoría válida"]);
        }

        App::get('router')->redirect('galeria');
    }

    public function show($id)
    {
        $imagenesRepository = App::getRepository(ImagenesRepository::class);
        $imagen = $imagenesRepository->find($id);
        Response::renderView(
            'imagen-show',
            'layout',
            compact('imagen', 'imagenesRepository')
        );
    }
}