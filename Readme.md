# DealerGoogleMap V0.1

This module request location from Google for Dealer and provide a google map with dealer informations.

## Installation

### Manually

* Copy the module into ```<thelia_root>/local/modules/``` directory and be sure that the name of the module is DealerGoogleMap.
* Activate it in your thelia administration panel

## Usage

After activation, you have to set Google API KEY for Geocoding API.
For more information : https://developers.google.com/maps/documentation/geocoding/

Each time you add a dealer in Dealer module, location information will be set automatically.


To access to the map a route is ready :
```
    <route id="dealergooglemap.front.map" path="/module/dealergooglemap/map">
        <default key="_controller">DealerGoogleMap:DealerGoogleMapFront:map</default>
        <default key="_view">map</default>
    </route>
```    

## Hook

3 hooks are available to insert content on map page

### dealermap.stylesheet

Hook to integrate CSS in map page

### dealermap.after-javascript-include

Hook to integrate JS in map page

### dealermap.javascript-initialization

Hook to integrate JS initialization in map page

