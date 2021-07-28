import React from "react";
import Chart from "../../components/Chart";

class Home extends React.Component
{
    render() {
        return (
            <>
                <div className="content-header">
                    <div className="container-fluid">
                        <div className="row mb-2">
                            <div className="col-12 col-md-6">
                                <h1 className="m-0">Dashboard</h1>
                            </div>
                            <div className="col-12 col-md-6">
                                <nav aria-label="breadcrumb">
                                    <ol className="breadcrumb float-md-end">
                                        <li className="breadcrumb-item active" aria-current="page">
                                            Dashboard
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="content">
                    <div className="container-fluid">
                        <div className="row">
                            <div className="col-lg-6">
                                <div className="card">
                                    <div className="card-header border-0">
                                        <div className="d-flex justify-content-between">
                                            <h3 className="card-title">Users</h3>
                                        </div>
                                    </div>
                                    <div className="card-body">
                                        <div className="position-relative mb-4">

                                            <Chart 
                                                id="users-chart"
                                                type="line"
                                                model="users" 
                                                url="/get-stats"
                                                style={ {} } />

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div className="col-lg-6">
                                <div className="card">
                                    <div className="card-header border-0">
                                        <div className="d-flex justify-content-between">
                                            <h3 className="card-title">Users</h3>
                                        </div>
                                    </div>
                                    <div className="card-body">
                                        <div className="position-relative mb-4">
                                        
                                            <Chart 
                                                id="second-users-chart"
                                                type="line" 
                                                model="users"
                                                url="/get-stats"
                                                style={ {} } />

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </>
        );
    }
}

export default Home;