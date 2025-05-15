<?php

namespace App\Http\Controllers\API;

use Multitenant;
use App\Helpers\Core\Helper;
use Illuminate\Http\Request;
use App\Http\Requests\StoreVersus;
use App\Http\Resources\Versus;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class VersusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $content = Multitenant::getModel('Content')::query();
        // $content->select('*');
        // if (!is_null($request->search)) {
        //     $content->with(['info.covers'])->withAndHas('info', function ($query) use ($request) {
        //         $query->where('language_id', $request->language_id ?: config('app.fallback_language.id'));
        //         $query->where('title', 'LIKE', '%'.$request->search.'%')->orWhere('text', 'LIKE', '%'.$request->search.'%');
        //     });
        // } else {
        //     $content->with(array('info.covers', 'info' => function ($query) use ($request) {
        //         $query->where('language_id', $request->language_id ?: config('app.fallback_language.id'));
        //     }));
        // }

        // $content = $content->orderBy('created_at', 'desc')->paginate(10);
        
        // return new Content($content);
    }

    /**
     * Store a newly created Resourcesce in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreContent $request)
    {
        // if ($request->fact_in_media === true) {
        //     return $this->storeFactInMedia($request);
        // }

        // /**
        //  * Create New Article
        //  * @var Multitenant
        //  */
        // $contentModel = Multitenant::getModel("Content");
        // $contentLanguageModel = Multitenant::getModel("ContentLanguage");
        // $verdictModel = Multitenant::getModel('Verdict');
        // \DB::beginTransaction();
        
        // try {
        //     $verdict = $verdictModel::where('id', $request->verdict_item_id)->with(['info' => function ($query) use ($request) {
        //         $query->where('language_id', $request->language_id);
        //     }])->first();

        //     if (is_null($verdict)) {
        //         throw new \Exception("Error Processing Request", 1);
        //     }
        //     if (is_null($verdict->info)) {
        //         throw new \Exception("Error Processing Request", 1);
        //     }

        //     if ($request->id) {
        //         $content = $contentModel::findOrFail($request->id);
        //     } else {
        //         $content          = new $contentModel;
        //         $content->type    = $request->type;
        //         $content->created_at = \Carbon\Carbon::parse($request->published_at);
                
        //         if ($request->user_id) {
        //             $content->user_id = $request->user_id;
        //         }
        //         $meta = [];
        //         if ($request->verdict_id && $request->verdict_item_id) {
        //             $meta['verdict'] = [
        //                 'id' => $request->verdict_id,
        //                 'item_id' => $request->verdict_item_id,
        //                 'position'=> $verdict->color,
        //                 'expires' => \Carbon\Carbon::now()->addMinutes(config('verdict.cache.minutes'))->timestamp,
        //             ];
        //         }
        //         $meta['options'] = $request->options ?: [];
        //         $content->meta = $meta;
        //         $content->save();
        //     }

        //     $contentLanguage = new $contentLanguageModel;

        //     $contentLanguage->title        = $request->title;
        //     $contentLanguage->description  = $request->description;
        //     $contentLanguage->text         = $request->text;
        //     $contentLanguage->slug         = $request->slug;
        //     $contentLanguage->content_id   = $content->id;
        //     $contentLanguage->language_id  = $request->language_id;
            
        //     if ($request->user_id) {
        //         $contentLanguage->user_id  = $request->user_id;
        //     }

        //     $contentLanguage->status      = $request->status;
        //     $contentLanguage->published_at = \Carbon\Carbon::parse($request->published_at);

        //     /**
        //      * Build meta field
        //      * @var array
        //      */
        //     $meta = [];
            
        //     if ($request->meta_keywords) {
        //         $meta['meta_keywords'] = implode(", ", $request->meta_keywords);
        //     }

        //     if ($request->region_keywords) {
        //         $meta['region_keywords'] = implode(", ", $request->region_keywords);
        //     }

        //     if ($request->verdict_id && $request->verdict_item_id) {
        //         $meta['verdict'] = ['title' => $verdict->info->title, 'description' => $verdict->info->description];
        //     }

        //     if (count($request->person_announcers)) {
        //         foreach ($request->persons as $person) {
        //             if (in_array($person, $request->person_announcers)) {
        //                 $find = Multitenant::getModel("Person")::withAndHas('info', function ($query) use ($request) {
        //                     $query->where('language_id', $request->language_id);
        //                 })->where('id', $person)->first();

        //                 if (!is_null($find)) {
        //                     $meta['person_announcers'][] = ['name' => $find->info->name.' ' .$find->info->surname, 'id' => $find->id];
        //                 }
        //             }
        //         }
        //     } else {
        //         $meta['person_announcers'] = [];
        //     }

        //     $contentLanguage->meta = $meta;
        //     $contentLanguage->save();

        //     /**
        //      * Sync tags
        //      */
        //     if ($request->tags) {
        //         $contentLanguage->attachTags($request->tags);
        //     }

        //     if ($request->covers) {
        //         /**
        //          * Attache covers
        //          */
        //         $coverModel = Multitenant::getModel('Cover');

        //         foreach ($request->covers as $key => $value) {
        //             $coverModel::Create([
        //                 'file_id'        => $value,
        //                 'cover_type'     => $request->cover_types[$key],
        //                 'coverable_type' => Multitenant::getModel('ContentLanguage'),
        //                 'coverable_id'   => $contentLanguage->id,
        //             ]);
        //         }
        //     }

        //     if ($request->attachments) {
        //         /**
        //          * Attache files
        //          */
        //         $fileable = Multitenant::getModel('Fileable');
        //         foreach ($request->attachments as $key => $value) {
        //             $fileable::Create([
        //                 'file_id'       => $value,
        //                 'fileable_type' => Multitenant::getModel('ContentLanguage'),
        //                 'fileable_id'   => $contentLanguage->id,
        //             ]);
        //         }
        //     }

        //     if ($request->pages) {
        //         $content->pages()->sync($request->pages);
        //     }

        //     if ($request->persons) {
        //         $content->persons()->sync($request->persons);
        //     }


        //     if ($request->options) {
        //         $content->options()->sync($request->options);
        //     }

        //     if ($request->verdict_id && $request->verdict_item_id) {
        //         $content->verdicts()->sync($request->verdict_id);
        //     }


        //     \DB::commit();
        //     return response()->json($content);
        // } catch (\Exception $e) {
        //     return response(['errors' => ["verdict" => ['Specified verdict does not have translation, translate first']]], 422)->header('Content-Type', 'application/json');
        // } catch (Exception $e) {
        //     \DB::rollBack();
        //     return response(['result' => $e->getMessage()], 500)->header('Content-Type', 'application/json');
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json([]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        // $model = Multitenant::getModel('Content');
        // try {
        //     //Find page with id and language id
        //     $content = $model::with([
        //         'info' => function ($query) use ($request) {
        //             $query->where('language_id', $request->language_id?:config('app.fallback_language.id'));
        //         },
        //         'info.covers',
        //         'info.files',
        //         'options',
        //         'info.tags',
        //         'pages.info',
        //         'verdicts.infos' => function ($query) use ($request) {
        //             $query->where('language_id', $request->language_id?:config('app.fallback_language.id'));
        //         },
        //         'persons.info' => function ($query) use ($request) {
        //             $query->where('language_id', $request->language_id?:config('app.fallback_language.id'));
        //             $query->with('covers');
        //         },
        //     ])->findOrFail($id);
        //     //if we can not find page with id and language, select very first page ignoring languge
        //     if (is_null($content->info)) {
        //         $content = $model::with([
        //             'info',
        //             'pages.info' => function ($query) use ($request) {
        //                 $query->where('language_id', $request->language_id?:config('app.fallback_language.id'));
        //                 $query->with('covers');
        //             },
        //             'info.covers',
        //             'info.files',
        //             'options',
        //             'info.tags',
        //             'persons.info' => function ($query) use ($request) {
        //                 $query->where('language_id', $request->language_id?:config('app.fallback_language.id'));
        //                 $query->with('covers');
        //             }
        //         ])->findOrFail($id);
        //     }
        // } catch (Exception $e) {
        //     return response(['result' => 'not found'], 404)->header('Content-Type', 'application/json');
        // }
        // return new Content($content);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreContent $request, $id)
    {
        // if ($request->fact_in_media) {
        //     return $this->updateFactInMedia($request);
        // }

        // $model = Multitenant::getModel('Content');
        
        // $content = $model::with(['info' => function ($query) use ($request) {
        //     $query->where('language_id', $request->language_id);
        // }, 'info.covers'])->findOrFail($id);


        // \DB::beginTransaction();
        
        // try {
        //     if ($request->verdict_id && $request->verdict_item_id) {
        //         $verdictModel = Multitenant::getModel('Verdict');
        //         $verdict = $verdictModel::where('id', $request->verdict_item_id)->with(['info' => function ($query) use ($request) {
        //             $query->where('language_id', $request->language_id);
        //         }])->first();
                
        //         if (is_null($verdict)) {
        //             \Log::info('a', [1]);
        //             throw new \Exception("Error Processing Request", 1);
        //         }
        //         if (is_null($verdict->info)) {
        //             \Log::info('a', [1]);
        //             throw new \Exception("Error Processing Request", 1);
        //         }
        //     }
            
        //     $content->type    = $request->type;
        //     $content->user_id = $request->user_id;
        //     $content->created_at = \Carbon\Carbon::parse($request->published_at);

        //     $meta = $content->meta;
        //     if ($request->verdict_id && $request->verdict_item_id) {
        //         $meta['verdict'] = [
        //             'id'      => $request->verdict_id,
        //             'item_id' => $request->verdict_item_id,
        //             'position'=> $verdict->color,
        //             'expires' => \Carbon\Carbon::now()->addMinutes(config('verdict.cache.minutes'))->timestamp,
        //         ];
        //     }

        //     $meta['options'] = $request->options ?: [];
        //     $content->meta = $meta;
        //     $content->save();

        //     $content->info->title        = $request->title;
        //     $content->info->description  = $request->description;
        //     $content->info->text         = $request->text;
        //     $content->info->slug         = $request->slug;
        //     $content->info->content_id   = $content->id;
        //     $content->info->language_id  = $request->language_id;
        //     $content->info->user_id      = $request->user_id;
        //     $content->info->status      = $request->status;
        //     $content->info->published_at = \Carbon\Carbon::parse($request->published_at);

        //     /**
        //      * remove all covers atached to this person
        //      */
        //     $content->info->covers()->detach();
        //     $content->persons()->detach();
        //     $content->info->files()->detach();
        //     $content->options()->detach();
        //     $content->pages()->detach();
        //     $content->verdicts()->detach();

        //     /**
        //      * Build meta field
        //      * @var array
        //      */
        //     $meta = [];
            
        //     if ($request->meta_keywords) {
        //         $meta['meta_keywords'] = implode(", ", $request->meta_keywords);
        //     }

        //     if ($request->region_keywords) {
        //         $meta['region_keywords'] = implode(", ", $request->region_keywords);
        //     }

        //     if ($request->verdict_id && $request->verdict_item_id) {
        //         $meta['verdict'] = ['title' => $verdict->info->title, 'description' => $verdict->info->description];
        //     }

        //     if (count($request->person_announcers)) {
        //         foreach ($request->persons as $person) {
        //             if (in_array($person, $request->person_announcers)) {
        //                 $find = Multitenant::getModel("Person")::withAndHas('info', function ($query) use ($request) {
        //                     $query->where('language_id', $request->language_id);
        //                 })->where('id', $person)->first();

        //                 if (!is_null($find)) {
        //                     $meta['person_announcers'][] = ['name' => $find->info->name.' ' .$find->info->surname, 'id' => $find->id];
        //                 }
        //             }
        //         }
        //     } else {
        //         $meta['person_announcers'] = [];
        //     }

        //     $content->info->meta = $meta;
        //     $content->info->save();

        //     /**
        //      * Sync tags
        //      */
        //     if ($request->tags) {
        //         $content->info->syncTags($request->tags);
        //     }

        //     if ($request->verdict_id && $request->verdict_item_id) {
        //         $model = Multitenant::getModel('Contentable');
        //         $model::Create([
        //                 'content_id'        => $content->id,
        //                 'content_type'      => config('content.types.article'),
        //                 'contentable_type'  => Multitenant::getModel('Verdict'),
        //                 'contentable_id'    => $request->verdict_id,
        //         ]);
        //     }


        //     if ($request->covers) {
        //         /**
        //          * Attache covers
        //          */
        //         $coverModel = Multitenant::getModel('Cover');

        //         foreach ($request->covers as $key => $value) {
        //             $coverModel::Create([
        //                 'file_id'        => $value,
        //                 'cover_type'     => $request->cover_types[$key],
        //                 'coverable_type' => Multitenant::getModel('ContentLanguage'),
        //                 'coverable_id'   => $content->info->id,
        //             ]);
        //         }
        //     }

        //     if ($request->attachments) {
        //         /**
        //          * Attache files
        //          */
        //         $fileable = Multitenant::getModel('Fileable');
        //         foreach ($request->attachments as $key => $value) {
        //             $fileable::Create([
        //                 'file_id'       => $value,
        //                 'fileable_type' => Multitenant::getModel('ContentLanguage'),
        //                 'fileable_id'   => $content->info->id,
        //             ]);
        //         }
        //     }

        //     if ($request->pages) {
        //         foreach ($request->pages as $page) {
        //             $contenableModel = Multitenant::getModel('Contentable');
        //             $contenableModel::Create([
        //                 'content_id'        => $content->id,
        //                 'content_type'      => config('content.types.article'),
        //                 'contentable_type'  => Multitenant::getModel('Page'),
        //                 'contentable_id'    => $page,
        //             ]);
        //         }
        //     }

        //     if ($request->persons) {
        //         foreach ($request->persons as $person) {
        //             Multitenant::getModel('Contentable')::Create([
        //                 'content_id'        => $content->id,
        //                 'content_type'      => config('content.types.article'),
        //                 'contentable_type'  => Multitenant::getModel('Person'),
        //                 'contentable_id'    => $person,
        //             ]);
        //         }
        //     }

        //     if ($request->options) {
        //         $optionable =  Multitenant::getModel('Optionable');
        //         foreach ($request->options as $option) {
        //             $optionable::Create([
        //                 'option_id'        => $option,
        //                 'optionable_type'  => Multitenant::getModel('Content'),
        //                 'optionable_id'    => $content->id,
        //             ]);
        //         }
        //     }

        //     \DB::commit();
        //     return response()->json($content);
        // } catch (\Exception $e) {
        //     return response(['errors' => ["verdict" => ['Specified verdict does not have translation, translate first']]], 422)->header('Content-Type', 'application/json');
        // } catch (\throwable $e) {
        //     \DB::rollBack();
        //     return response(['result' => $e->getMessage()], 500)->header('Content-Type', 'application/json');
        // }
    }
}
