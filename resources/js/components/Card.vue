<template>
        <div class="contenedor" @click="FlipMe">
            <div v-if="notFlipped" class="card carta" :style="cardColor">
                <span class="player-level">Lvl. {{Level}}</span>
                <div class="hp-bar">
                    <div v-if="Player" :style="HPStyle" class="hp-bar-fill-player"></div>
                    <div v-if="!Player" :style="HPStyle" class="hp-bar-fill-opponent"></div>
                    <h4 v-if="Player" class="hp">{{HP}}/{{maxHP}}</h4>
                </div> 
                <img class="card-img-top" :src="Img" :alt="Name">
               
                <span class="card-name">
                    <img class="types-icon" :src="getType" />
                        {{Name}}
                    <img class="types-icon" :src="getType" />
                </span>
                <!--<span class="card-text">ATK: {{ATK}}</span>
                <span class="card-text">DEF: {{DEF}}</span>
                <span class="card-attack">SPD: {{SPD}}</span>-->
            </div>
            <div v-else-if="!notFlipped" class="card behind carta">
                <span class="behind-card-name">
                    <img class="types-icon" :src="getType" />
                        {{Name}}
                    <img class="types-icon" :src="getType" />
                </span>
                <span class="card-text">ATK: {{ATK}}</span>
                <span class="card-text">DEF: {{DEF}}</span>
                <span class="card-attack">SPD: {{SPD}}</span>
            </div>
        </div>

</template>

<script>

export default {
    name: 'Carta',
    data(){
            return {
                IconsPath: 'https://raw.githubusercontent.com/HoussamBenali/Assets/main/images/Types/',
                notFlipped: true,
                IPath: null,      
            };
        },
    props: {
        Player: {},
        Name: {},
        Type: {},
        Level: {},
        HP: {},
        Img: {},
        ATK:{},
        DEF: {},
        SPD: {},
        HPBar: {},
        maxHP: {},
        Rarity:{}
    },
    computed: {
            HPStyle(){    
                let color = '#f02b2b';
                        
                if(this.HP >= 0.7*this.maxHP){
                    color = '#33bd96';
                }       
                else if(this.HP >= 0.3*this.maxHP){
                    color = '#ff9012';
                }
                console.log(this.Player)
                console.log(this.maxHP, 'maxHP')
                console.log(this.HP, 'HP')
                var percent=this.HP/this.maxHP*100
                percent = Math.round(percent)
                console.log(percent, 'percent')
                if (percent<=0){
                    return {
                        width: '100%',
                        background: 'none',
                        border: "none",
                        
                    }

                } else {
                    return {
                        width: String(percent) + '%',
                        background: color,
                        border: "1px solid black",
                        }
                }
                
     
            },
                hasHP(){
                    return this.HP > 0;
                },
                getType(){
                    setTimeout(() => { this.IPath= this.IconsPath+this.Type+'.png'},350)
                return this.IPath
            },
             cardColor(){
                 
                if (this.Rarity=="common"){
                    return  {"background-image": "linear-gradient( to top left, white, gray, white)"}
                }
                  else if (this.Rarity=="rare"){
                    return  {"background-image": "linear-gradient(to top left, white, #009933 , white )"}
                }
                else if (this.Rarity=="superrare"){
                    return  {"background-image": "linear-gradient(to top left, white, #blue , white )"}
                }
                else if (this.Rarity=="unique"){
                     return  {"background-image": "linear-gradient(to top left, white, #cc00cc, white )"}
                }
                else if (this.Rarity=="legendary"){
                     return  {"background-image": "linear-gradient(to top left, white, orange , white )"}
                }

            }

            
        },


        methods: {
             FlipMe(){
                if (this.notFlipped==false){
                    this.notFlipped=true;

                } else {
                     this.notFlipped=false;
                  }
            },
            
           
            
            
    }
}
</script>

<style lang="css">
@import "../../css/cards.css";
.im-flipped {
    transform: rotateY(180deg);
}
</style>