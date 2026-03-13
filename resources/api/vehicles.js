import axios from 'axios'

export async function getVehiclesList() {
    const { data } = await axios.get('/vehicles/list')
    return data.results
}

export async function saveVehicle(id, payload) {
    const { data } = await axios.post(`/vehicles/save/${id}`, payload)
    return data
}

export async function removeVehicle(id) {
    const { data } = await axios.post(`/vehicles/delete/${id}`)
    return data
}
