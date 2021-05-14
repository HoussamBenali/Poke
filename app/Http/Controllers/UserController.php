<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pokemon;
use App\Models\Cart;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller{


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
        $users=User::all();
        return $users;
    }

    public function store(Request $request){
        $user=User::create($request->all());
        return $user;
    }

    public function setPokemon(Request $request){
        $id=\Auth::user()->id;
        $user=User::where('id',$id)->first();
        $pokemons= unserialize($user->pokemons);
        //dd($pokemons);
        if ($pokemons == null){
            $pokemons = [$request->id];
        } else{
            if(in_array($request->id, $pokemons )){
                return false;
            }
            else{
                array_push($pokemons, $request->id);
            }   
        }

        $poke_array = serialize($pokemons);
        if (count($pokemons)<5){
            $poke= DB::table('users')
            ->where('id',$id)
            ->update(['pokemons' => $poke_array, 'main_deck' => $poke_array]);
        } else {
            $poke= DB::table('users')
            ->where('id',$id)
            ->update(['pokemons' => $poke_array]);
        }

        return $poke;
    }

    public function getDeck(Request $request){
        $id=\Auth::user()->id;
        $user=User::where('id',$id)->first();
        $pokemons=[];
        $main_deck= unserialize($user->main_deck);
        
        for ($i=0; $i < count($main_deck); $i++) { 
           $pokemon = Pokemon::where('id', $main_deck[$i])->first();

           $pokemon->moves= unserialize($pokemon->moves);
           $moves=$pokemon->moves;
   
           $strjson = '[';
           for ($j=0; $j < count($moves); $j++) { 
               $strjson .= $moves[$j];
               if($j < count($moves)-1) $strjson .= ', ';
           }
           $strjson .= ']';
     
           $pokemon->moves=json_decode($strjson);
           array_push($pokemons, $pokemon);
           //error_log($i);
        }  

        //dd($pokemons);
        return $pokemons;

    }

    public function setRewards(Request $request){
        $id=\Auth::user()->id;
        $user=User::where('id',$id)->first();
        $pokemons= unserialize($user->pokemons);
        error_log($request->coins);
        error_log($request->droppedPokemon);
        $coins=$request->coins;
        $coins=$coins+$user->coins;
        error_log($coins);
        DB::table('users')
            ->where('id',$id)
            ->update(['coins' => $coins]); 
        
        if (in_array($request->droppedPokemon, $pokemons) || $request->droppedPokemon==null){
            error_log('already owned');
            return $request->droppedPokemon=null;
        } else{
            array_push($pokemons, $request->droppedPokemon);
            $poke_array = serialize($pokemons);
            DB::table('users')
            ->where('id',$id)
            ->update(['pokemons' => $poke_array]); 
        }
           
        return $user;
    }

    public function restar_price (Request $request) {
        // dd($request->all()['price']);
        $price = $request->all()['price'];
        $id=\Auth::user()->id;
        $user=User::where('id',$id)->first();

        // dd($price,$user->coins);
        $res = $user->coins -= $price;
        // $res = $user->coins -= 1;
        // dd($user);
        $user->save();
        return $res;

    }

    public function sumar_price (Request $request) {
        // dd($request->all()['price']);
        $price = $request->all()['price'];
        $id=\Auth::user()->id;
        $user=User::where('id',$id)->first();
        // dd($price,$user->coins);
        $res = $user->coins += $price;
        // $res = $user->coins += 1;
        // dd($user);
        $user->save();
        return $res;
    }

    public function save_poke (Request $request) {
        $total = $request->all()['price_total'];
        $pokes_id = $request->all()['pokes_id'];
        $ids=[];
        // dd($total,$pokes_id);
        for ($x=0; $x<count($pokes_id); $x++){
            // dd($pokes_id[$x]["id"]);
            array_push($ids, $pokes_id[$x]["id"]);
        }
        // dd($ids);
        
        $id=\Auth::user()->id;
        $user=User::where('id',$id)->first();

        if ($user->pokemons == null){
            $user->pokemons = serialize($ids);
        }else{
            $new_array = unserialize($user->pokemons);
            // dd($new_array);
            for ($x=0; $x<count($pokes_id); $x++){
                array_push($new_array, $ids[$x]);
            }
            $user->pokemons = serialize($new_array);
        }
        // dd($user);
        
        $user->save();
        $this->resetCart();
        return "Compra realizada correctamente";
        // dump($user);
        // dd($user);
    }


    public function resetCart () {
        $id_user=\Auth::user()->id;
        $cart=Cart::where('user_id',$id_user)->delete();
    }

    public function pokesUser(){
        $id=\Auth::user()->id;
        $user=User::where('id',$id)->first();
        $pokemons= unserialize($user->pokemons);
        return $pokemons;
    }

    public function PricePoke (){
        $pokemons = Pokemon::all();
        for ($x=0; $x<count($pokemons); $x++){
            $rare = $pokemons[$x]->rarity;
            switch ($rare) {
                case 'common':
                    $pokemons[$x]->price = 5000;
                    $pokemons[$x]->save();
                    break;
                case 'rare':
                    $pokemons[$x]->price = 15000;
                    $pokemons[$x]->save();
                    break;
                case 'superrare':
                    $pokemons[$x]->price = 25000;
                    $pokemons[$x]->save();
                    break;
                case 'unique':
                    $pokemons[$x]->price = 50000;
                    $pokemons[$x]->save();
                    break;
  
                case 'legend':
                    $pokemons[$x]->price = 100000;
                    $pokemons[$x]->save();
                    break;
            }
        }
        //dd($pokemons);
    }
 


}

