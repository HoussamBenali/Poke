<template>
  <div id="aplication">
 
    <div class="header">
      <!--<Nav></Nav>-->
      <Nav v-if="['login', 'register', 'forgot', 'reset', 'home', 'base', 'adventure', 'profile','shop'].includes($route.name)"></Nav>
    </div>
    <div class="main">
      <router-view/>
    </div>

  </div>
</template>

<script>
import axios from 'axios';
import Nav from './components/Nav';


export default {
  name: 'index',
  components: {
    Nav,
  },   
  
}

</script>

<style lang="scss">

@media (min-width: 630px) {
#aplication {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  background-color: #f6f7c7;
  min-height: 100vh;
  height: fit-content;
  
}

.header > a{
  color: #2c3e50;
  text-decoration: none;

}

}

@media (max-width: 630px){

#aplication {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  background-color: #f6f7c7;
  min-height: 100vh;
  height: fit-content;

  }
}


</style>