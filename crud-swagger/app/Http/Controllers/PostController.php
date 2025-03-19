<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Laravel Post API",
 *      description="API de gestion des posts",
 *      @OA\Contact(
 *          email="admin@example.com"
 *      ),
 * )
 */
class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     /**
     * @OA\Get(
     *      path="/api/posts",
     *      operationId="getPostsList",
     *      tags={"Posts"},
     *      summary="Obtenir tous les posts",
     *      @OA\Response(response=200, description="Liste des posts"),
     * )
     */ 
    public function index()
    {
        return response()->json(Post::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Post(
     *      path="/api/posts",
     *      operationId="storePost",
     *      tags={"Posts"},
     *      summary="Créer un post",
     *      @OA\RequestBody(
     *          @OA\JsonContent(
     *              required={"title","content"},
     *              @OA\Property(property="title", type="string"),
     *              @OA\Property(property="content", type="string"),
     *          ),
     *      ),
     *      @OA\Response(response=201, description="Post créé"),
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $post = Post::create($validated);
        return response()->json($post, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */

     /**
     * @OA\Get(
     *      path="/api/posts/{id}",
     *      operationId="getPostById",
     *      tags={"Posts"},
     *      summary="Obtenir un post par ID",
     *      description="Retourne un post spécifique selon son ID",
     *      @OA\Parameter(
     *          name="id",
     *          description="ID du post",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Post récupéré avec succès"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Post non trouvé"
     *      )
     * )
     */
    public function show(Post $post)
    {
        return response()->json($post, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Put(
     *      path="/api/posts/{id}",
     *      operationId="updatePost",
     *      tags={"Posts"},
     *      summary="Mettre à jour un post",
     *      description="Met à jour les informations d'un post",
     *      @OA\Parameter(
     *          name="id",
     *          description="ID du post",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="title", type="string", example="Nouveau titre"),
     *              @OA\Property(property="content", type="string", example="Nouveau contenu du post")
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Post mis à jour avec succès"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Post non trouvé"
     *      )
     * )
     */
    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string',
        ]);

        $post->update($validated);
        return response()->json($post, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return response()->json(['message' => 'Post deleted successfully'], 200);
    }
}
