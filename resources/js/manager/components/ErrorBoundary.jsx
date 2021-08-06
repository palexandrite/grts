import React from "react";

/**
 * @todo This component uses 'Error boundary' but it did not tested in the current app
 */

class ErrorBoundary extends React.Component
{
    constructor( props )
    {
        super( props );
        this.state = {
            hasErrors: false,
            error: {
                message: null,
                stack: null
            },
            errorInfo: null
        };
    }

    static getDerivedStateFromError( error )
    {
        // Update state so the next render will show the fallback UI.
        return { hasError: true };
    }

    componentDidCatch(error, errorInfo)
    {
        // You can also log the error to an error reporting service
        this.setState({ error, errorInfo });
    }

    render()
    {
        const { hasErrors, error, errorInfo } = this.state;

        if ( hasErrors ) {
            console.log( error, errorInfo );

            // You can render any custom fallback UI
            return (
                <h2>Something went wrong.</h2>
            );
        }

        return this.props.children; 
    }
}

export default ErrorBoundary;