console.log(check_color(cases_in_states[7]));
console.log(cases_in_states[7]);
console.log(cases_in_states.length);
var simplemaps_countrymap_mapdata = {
    main_settings: {
        //General settings
        width: "responsive", //'700' or 'responsive'
        background_color: "#000",
        background_transparent: "yes",
        border_color: "#ffffff",

        //State defaults
        state_description: "State description",
        state_color: "#c8c8c8",
        state_hover_color: "#88A4BC",
        state_url: "",
        border_size: 1.0,
        all_states_inactive: "no",
        all_states_zoomable: "yes",

        //Location defaults
        // location_description: "",
        // location_url: "",
        // location_color: "#FF0067",
        // location_opacity: 0.8,
        // location_hover_opacity: 1,
        // location_size: 25,
        // location_type: "square",
        // location_image_source: "frog.png",
        // location_border_color: "#FFFFFF",
        // location_border: 2,
        // location_hover_border: 2.5,
        // all_locations_inactive: "no",
        // all_locations_hidden: "no",

        //Label defaults
        label_color: "#d5ddec",
        label_hover_color: "#d5ddec",
        label_size: 22,
        label_font: "Arial",
        hide_labels: "no",
        hide_eastern_labels: "no",

        //Zoom settings
        zoom: "yes",
        manual_zoom: "yes",
        back_image: "no",
        initial_back: "no",
        initial_zoom: "-1",
        initial_zoom_solo: "no",
        region_opacity: 1,
        region_hover_opacity: 0.6,
        zoom_out_incrementally: "yes",
        zoom_percentage: 0.99,
        zoom_time: 0.5,

        //Popup settings
        popup_color: "white",
        popup_opacity: 0.9,
        popup_shadow: 1,
        popup_corners: 5,
        popup_font: "12px/1.5 Verdana, Arial, Helvetica, sans-serif",
        popup_nocss: "no",

        //Advanced settings
        div: "map",
        auto_load: "yes",
        url_new_tab: "no",
        images_directory: "default",
        fade_time: 0.1,
        link_text: "View Website",
        popups: "detect",
        state_image_url: "",
        state_image_position: "",
        location_image_url: ""
    },
    state_specific: {
        MYS1137: {
            color: check_color(cases_in_states[8]),
            name: "Perak",
            description: cases_in_states[8],
        },
        MYS1139: {
            color: check_color(cases_in_states[7]),
            name: "Pulau Pinang",
            description: cases_in_states[7],
        },
        MYS1140: {
            color: check_color(cases_in_states[2]),
            name: "Kedah",
            description: cases_in_states[2],
        },
        MYS1141: {
            color: check_color(cases_in_states[9]),
            name: "Perlis",
            description: cases_in_states[9],
        },
        MYS1143: {
            color: check_color(cases_in_states[1]),
            name: "Johor",
            description: cases_in_states[1],
        },
        MYS1144: {
            color: check_color(cases_in_states[3]),
            name: "Kelantan",
            description: cases_in_states[3],
        },
        MYS1145: {
            color: check_color(cases_in_states[4]),
            name: "Melaka",
            description: cases_in_states[4],
        },
        MYS1146: {
            color: check_color(cases_in_states[5]),
            name: "Negeri Sembilan",
            description: cases_in_states[5],
        },
        MYS1147: {
            color: check_color(cases_in_states[6]),
            name: "Pahang",
            description: cases_in_states[6],
        },
        MYS1148: {
            color: check_color(cases_in_states[10]),
            name: "Selangor",
            description: cases_in_states[10],
        },
        MYS1149: {
            color: check_color(cases_in_states[11]),
            name: "Terengganu",
            description: cases_in_states[11],
        },
        MYS1186: {
            color: check_color(cases_in_states[12]),
            name: "Sabah",
            description: cases_in_states[12],
        },
        MYS1187: {
            color: check_color(cases_in_states[13]),
            name: "Sarawak",
            description: cases_in_states[13],
        },
        MYS4831: {
            color: check_color(cases_in_states[14]),
            name: "Kuala Lumpur",
            description: cases_in_states[14],
        },
        MYS4832: {
            color: check_color(cases_in_states[15]),
            name: "Putrajaya",
            description: cases_in_states[15],
        },
        MYS4833: {
            color: check_color(cases_in_states[16]),
            name: "Labuan",
            description: cases_in_states[16],
        }
    },
    locations: {

    },
    labels: {},
    regions: {},
    data: {
        data: {
            
        }
    }
};
