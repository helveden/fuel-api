import React, {Component} from 'react';

import axios from 'axios';

class Default extends Component {

    constructor(props) {
        super(props);
        this.state = {
            city: "",
            cities: [],
            openPdv: false,
            pdvs: [],
        }

        this.handleChangeCity = this.handleChangeCity.bind(this);
        this.submitSearchCities = this.submitSearchCities.bind(this);

        this.handleOpenPdv = this.handleOpenPdv.bind(this);
        
    }
    
    
    componentDidMount() {
        // rechercher s'il y a un id pour l'update
    }

    componentDidUpdate(prevProps, prevState, snapshot) {
    
    }

    
    
    handleChangeCity(event) {   
        const target = event.target;
        const value = target.type === 'checkbox' ? target.checked : target.value;
        const name = target.name;
    
        this.setState({
            [name]: value
        });
    }

    async handleOpenPdv(city) {
        
        var results = await axios.post('/api/pdvs', {context: city.context})
        .then(function(response) {
            return response;
        });

        this.setState({
            openPdv: true,
            pdvs: results.data
        });
    }
    

    async submitSearchCities(event) {
        event.preventDefault();

        var results = await axios.get('/api/cities/' + this.state.city)
        .then(function(response) {
            return response;
        });

        console.log(results)
        
        this.setState({
            cities: results.data.features
        });
    }

    render() {
        const cities = this.state.cities

        return (
            <>
                <nav className='alert alert-light'>
                    <form
                        onSubmit={this.submitSearchCities}
                    >
                        <ul className="row">
                            <li className="col-md-3">
                                <input 
                                    type="text" 
                                    className="form-control" 
                                    placeholder="Ville"
                                    name="city"
                                    value={this.state.city}
                                    onChange={this.handleChangeCity}
                            />
                            </li>
                            <li className="col-md-3">
                                <button className="btn btn-secondary">Chercher</button>
                            </li>
                        </ul>
                    </form>
                </nav>
                <table className="table">
                    <tbody>
                        {cities.map((feature, index) => {
                            return <tr key={index}>
                                <td><button type="button" onClick={() => this.handleOpenPdv(feature.properties)}>{feature.properties.city}</button></td>
                                <td>{feature.properties.postcode}</td>
                                <td>{feature.properties.context}</td>
                            </tr>
                        })}
                    </tbody>
                </table>
            </>  
        ) 
    }
}
export default Default;