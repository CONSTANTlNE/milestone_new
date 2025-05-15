<?php
namespace App\Services;
use Illuminate\Support\Str;
use App\Models\Seo;
use App\Models\SeoTrans;
use App\Models\Locale;

class Seoable
{
    public static function createSeo($model, $request, $id)
    {
        $modelSeoTrans =[];

        $newLangs =[];

        for($i=0;$i<sizeof($request->lang);$i++)
        {
            if($request->seoTitle[$i]=="")
            {
                unset($request->seoTitle[$i]);
                unset($request->seoDescription[$i]);
                unset($request->seoKeyword[$i]);
            }else{
                array_push($newLangs,$request->lang[$i]);
            }
        }

        $newSeoTitle = array_values($request->seoTitle);
        $newSeoDescription = array_values($request->seoDescription);
        $newSeoKeyword = array_values($request->seoKeyword);

        for($y=0;$y<sizeof($newSeoTitle);$y++)
        {
            array_push($modelSeoTrans,new SeoTrans(['title'=>$newSeoTitle[$y],
                                                'description'=>$newSeoDescription[$y],
                                                'keywords'=>$newSeoKeyword[$y],
                                                'seo_id'=>$id,
                                                'locale_id'=>$newLangs[$y]]));
        }

        return $modelSeoTrans;

        throw new \Exception('Can not create a unique slug');
    }

    public static function updateSeo($model, $request, $seo)
    {
        $langs = Locale::all();
        $seoFirst = $seo->first();
        if(empty($seoFirst->id) || $seoFirst->id==null){
            $seo->create();
        }

        foreach($langs as $key => $language)
        {
            if(!empty($seoFirst->id) && $seoFirst->id!=null){
                $seoTrans = $seoFirst->transModel()->where('locale_id', $language->id)->first();
            }

            if(!empty($request->seoTitle[$key]))
            {
                if(!empty($seoTrans))
                {
                     $seoTrans->update([
                        'title'      => $request->seoTitle[$key],
                        'keywords'    => $request->seoKeyword[$key],
                        'description'    => $request->seoDescription[$key],
                    ]);
                }else{
                    SeoTrans::create([
                        'title'      => $request->seoTitle[$key],
                        'keywords'    => $request->seoKeyword[$key],
                        'description'    => $request->seoDescription[$key],
                        'seo_id'    => $seo->first()->id,
                        'locale_id'  => $language->id,
                    ]);
                }
            }else{
                $seoFirst->transModel()->where('locale_id', $language->id)->delete();
            }
        }
    }
}