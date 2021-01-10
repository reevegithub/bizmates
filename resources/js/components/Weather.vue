<template>
  <div class="text-white mb-8">
    <div class="places-input text-gray-800">
       <input type="search" id="address" class="form-control" placeholder="Choose a city..." />
      <p>Selected: <strong id="address-value">none</strong></p>
    </div>
    <div class="weather-container font-sans w-128 max-w-lg rounded-lg overflow-hidden bg-gray-900 shadow-lg mt-4">
        <div class="current-weather flex items-center justify-between px-6 py-8">
            <div class="flex items-center">
                <div>
                    <div class="text-6xl font-semibold">{{this.currentTemp.actual}}°C</div>
                    <br>
                     <div>Feels like {{this.currentTemp.feels}}°C</div>
                     <div>{{this.time}}</div>
                </div>
                <div>
                     <div class="mx-5">
                         <div class="font-semibold">{{this.currentTemp.summary.charAt(0).toUpperCase()+this.currentTemp.summary.slice(1)}}</div>
                         <div>{{this.location.name}}</div>
                         <br>
                          
                     </div>
                </div>
             </div>
            
            <div>
                <img v-bind:src="currentTemp.icon" />

            </div>
        </div> <!-- weather current end -->
        <div class="future-weather text-sm bg-gray-800 px-6 py-8 overflow-hidden">
            <div 
            v-for="(day, index) in dailyFiveDays"
            :key="day.dt"
            class="flex items-center"
            :class="{ 'mt-8' : index > 0}"
            v-if="index < 3"
            >
                <div class="w-1/6 text-lg text-gray-200">{{ toDayOfWeek(day.dt) }}</div>
                <div class ="w-4/6 px-4 flex items-center">
                    <div><img v-bind:src="'http://openweathermap.org/img/wn/'+ day.weather[0].icon + '@2x.png'" /></div>
                    <div class="ml-3">{{ day.weather[0].description }}</div>
                </div>
                <div class="w-1/6 text-right">
                    <div>{{ Math.round(day.temp.max)}}°C</div>
                    <div>{{ Math.round(day.temp.min)}}°C</div>
                </div>
             </div>
             <div class="w-3/6 text-lg text-gray-200">Popular Places</div>  
        
            <div 
            v-for="(pop, index) in popular"
            :key="pop.id"
            class="flex items-center"
            :class="{ 'mt-8' : index > 0}"
            v-if="index < 3"
            >
                <div class="w-4/6">{{pop.venue.name}}</div>
                <div class ="w-4/6 px-4 flex items-center">
                    <div class="ml-3">{{pop.venue.categories[0].name}}</div>
                </div>
                <div class="w-5/6 text-right">
                    <div>{{pop.venue.location.address}}</div>
                </div>
             </div>  
        </div>

     </div>
     <!-- weather container end -->
     
</div>
</template>

<script>

    export default {
        mounted() {
            this.fetchData()
            this.searchVenue()
            var placesAutocomplete = places({
                appId: 'plO920E0AVIV',
                apiKey: 'dc6f12b7212ff13035caef0cdadc4d3c',
                container: document.querySelector('#address')
                    }).configure({
                        type: 'city',
                        aroundLatLngViaIP: true,
                    });
    var $address = document.querySelector('#address-value')
      placesAutocomplete.on('change', (e) => {
        $address.textContent = e.suggestion.value
        this.location.name = `${e.suggestion.name}, ${e.suggestion.country}`
        this.location.lat = e.suggestion.latlng.lat
        this.location.lng = e.suggestion.latlng.lng
      });
      placesAutocomplete.on('clear', function () {
        $address.textContent = 'none';
      });
  },
  watch: {
    location: {
      handler(newValue, oldValue) {
        this.fetchData()
        this.searchVenue()
      },
      deep: true
    }
        },
          computed: {
            dailyFiveDays() {
            return this.daily.filter((day, index) => index < 3 )
            },
            popular() {
            return this.filter.filter((pop, index) => index < 3 )
            }
        },
        data(){
            return{
                time:'',
                currentTemp:{
                    actual:'',
                    feels:'',
                    summary:'',
                    icon:''
                },
                daily:[],
                filter:[],
                  location:{
            name:'Japan',
            lat: 36.2048,
            lng: 138.2529,
        },

            }
        },
      
        methods:{
            searchVenue(){
                fetch(`/api/venue?lat=${this.location.lat}&lng=${this.location.lng}`)
                .then(response => response.json())
                .then(data => {
                 
                   this.filter = data.response.groups[0].items
                   
                }
                )
            },
              itemSelected (item) {
                this.item = item;
                },
                setLabel (item) {
                return item.name;
                },
                inputChange (text) {
                // your search method
                this.items = items.filter(item => item.name.contains(text));
                // now `items` will be showed in the suggestion list
                },
        
            fetchData(){
                fetch(`/api/weather?lat=${this.location.lat}&lng=${this.location.lng}`)
                .then(response => response.json())
                .then(data => {
                    this.currentTemp.actual = Math.round(data.current.temp)
                    this.currentTemp.feels = Math.round(data.current.feels_like)
                    this.currentTemp.summary = data.current.weather[0].description
                    this.currentTemp.icon = 'http://openweathermap.org/img/wn/'+ data.current.weather[0].icon + '@2x.png'
                    this.daily=data.daily
                    this.time = new Date().toLocaleString('en-US', { timeZone: data.timezone })
                  
                }
                )
            },
            toDayOfWeek(timestamp){
                const newDate = new Date(timestamp*1000)
                const days = ['SUN','MON','TUE','WED','THU','FRI','SAT']
                return days[newDate.getDay()]
            }
        }
    }
     
</script>
