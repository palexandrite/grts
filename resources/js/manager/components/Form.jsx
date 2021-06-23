import React from "react";
import { Link, withRouter } from 'react-router-dom';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import PropTypes from "prop-types";

import Spinner from "./Spinner";

class Form extends React.Component
{
    static propTypes = {
        match: PropTypes.object.isRequired,
        location: PropTypes.object.isRequired,
        history: PropTypes.object.isRequired
    };

    constructor(props)
    {
        super(props);
        this.state = {
            item: {},
            isCreatePage: false,
            isRendered: false,
            isSubmitted: false,
        };

        this.handleSubmit = this.handleSubmit.bind(this);
        this.handleChange = this.handleChange.bind(this);
    }

    componentWillUnmount()
    {
        this.setState({
            item: {},
        });
    }

    componentDidMount()
    {
        if ( this.props.match.params.id ) {

            let url = "/manager/get-" + this.props.model,
                params = {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-Requested-With": "XMLHttpRequest",
                        "X-CSRF-Token": document.querySelector("meta[name=csrf-token]").content
                    },
                    body: JSON.stringify({
                        item: this.props.match.params.id
                    }),
                };
    
            fetch( url, params )
                .then(response => response.json())
                .then(data => {
                    this.setState({
                        item: this.prepareItem( data ),
                        isRendered: true
                    });
                })
                .catch(error => console.error("Pipe all hands on deck! We've got an error with the response", error));

        } else if ( this.props.match.url ) {

            let match = this.props.match.url.match( new RegExp("\/create$", "i") ) || [];
            if ( match.length > 0 ) {
                this.setState({
                    isCreatePage: true,
                    isRendered: true,
                });
            }

        } else {
            throw new Error("Something went wrong related to the URL!");
        }
    }

    prepareItem( item )
    {
        item.password = "";
        return item;
    }

    handleSubmit( e )
    {
        e.preventDefault();

        console.log("this is a payload");
        console.dir(this.state.item);

        let fetchParams = {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-Token": document.querySelector("meta[name=csrf-token]").content
            },
            body: JSON.stringify(this.state.item),
        };

        fetch("/manager/edit-user", fetchParams)
            .then(response => response.json())
            .then(data => {

                console.log("this is a response");
                console.dir(data);

                if ( data.errors ) {
                    // show validation errors
                } else if ( !data.isSaved ) {
                    // show the error message of saving to the DB
                } else {
                    // show success message and redirect to the home page of the current page
                }
                // this.setState({
                //     attributes: this.getAttributes(),
                //     item: this.prepareData(data),
                //     isRendered: true
                // });
            })
            .catch(error => console.error("Pipe all hands on deck! We've got an error with the submit.", error));
    }

    handleChange( e )
    {
        const target = e.target;
        const value = target.type === "checkbox" ? target.checked : target.value;
        const name = target.name;

        this.setState((prevState) => {
            let prevItem = prevState.item;
            prevItem[ name ] = value;
            return {
                item: prevItem,
            };
        });
    }

    getLabelElement( object )
    {
        let $label = false;

        if ( object.labelElement ) {

            const { text, ...attributes } = object.labelElement;

            $label = (
                <label { ...attributes }>{ text }</label>
            );

        } else if ( object.spanElement ) {

            const { ...attributes } = object.spanElement;

            $label = (
                <span { ...attributes }>{ "ID: " + object.value }</span>
            );

        }

        return $label;
    }

    getAutocompleteForInput( inputType )
    {
        let autocomplete;

        if ( inputType === "password" ) {
            autocomplete = this.state.isCreatePage ?  "new-password" : "current-password";
        } else if ( inputType === "email" ) {
            autocomplete = "email";
        }

        return autocomplete !== null ? autocomplete : undefined;
    }

    getInputElement( object )
    {
        let $inputElement = false;

        if ( object.inputElement ) {

            let autocomplete = this.getAutocompleteForInput( object.inputElement.type );

            if ( object.inputElement.type === "checkbox" ) {
                $inputElement = (
                    <input
                        { ...object.inputElement } 
                        defaultChecked={ object.value === "Active" }
                        onChange={ this.handleChange } />
                );
            } else if ( object.inputElement.type === "hidden" ) {
                $inputElement = (
                    <input { ...object.inputElement } value={ object.value } />
                );
            } else {
                $inputElement = (
                    <input
                        { ...object.inputElement }
                        autoComplete={ autocomplete }
                        defaultValue={ object.value }
                        onChange={ this.handleChange } />
                );
            }
        }

        return $inputElement;
    }

    getLayoutOfElement( object, label, input )
    {
        let { beginLayoutWith } = object;

        if ( beginLayoutWith !== undefined && beginLayoutWith === "input" ) {
            return (
                <>{ input }{ label }</>
            );
        }

        return (
            <>{ label }{ input }</>
        );
    }

    getFormElements()
    {
        let $output = [],
            $label,
            $inputElement,
            $elementLayout;

        if ( Object.keys( this.props.fields ).length > 0 ) {

            this.props.fields.map((value, index) => {

                if ( this.state.isCreatePage && index === 0 ) {
                    return;
                } else if (! this.state.isCreatePage ) {
                    for ( let prop in this.state.item )
                    {
                        if ( this.state.item.hasOwnProperty( prop ) ) {
                            if ( value.inputElement.name === prop ) {
                                value.value = this.state.item[ prop ];
                                break;
                            }
                        }
                    }
                }

                $label = this.getLabelElement( value );

                $inputElement = this.getInputElement( value );

                $elementLayout = this.getLayoutOfElement( value, $label, $inputElement );

                if ( value.wrapperElement ) {
                    $output.push(
                        <div key={ index } { ...value.wrapperElement }>
                            { $elementLayout }
                        </div>
                    );
                }
            });
        }

        return $output;
    }

    rednerForm()
    {
        return (
            <form onSubmit={ this.handleSubmit }>

                { this.getFormElements() }

                <input type="submit" value="Submit" className="btn btn-primary"/>
            </form>
        );
    }

    /*
     * The main method of the object
    */
    render()
    {
        const { isRendered } = this.state;
        const linkTo = "/manager/" + this.props.model + "s";

        return (
            <div className="card">
                <div className="card-header">
                    <Link 
                        to={ linkTo }
                        className="btn btn-link"
                        data-object="expandable"
                    >
                        <FontAwesomeIcon 
                            icon={ ["fas", "chevron-left"] } 
                            size="1x" />
                        <span>
                            Back to all
                        </span>
                    </Link>
                    <span className="border-start ps-2">{ this.props.currentText }</span>
                </div>
                <div className="card-body">

                    { isRendered ? this.rednerForm() : <Spinner /> }
                    
                </div>
            </div>
        );
    }
}

export default withRouter( Form );