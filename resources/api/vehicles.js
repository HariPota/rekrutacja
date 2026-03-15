import axios from 'axios'

export async function createVehicle(payload) {
    const { data } = await axios.post('/vehicles/create', payload)
    return data
}

export async function updateVehicle(id, payload) {
    const { data } = await axios.post(`/vehicles/update/${id}`, payload)
    return data
}

export async function removeVehicle(id) {
    const { data } = await axios.post(`/vehicles/delete/${id}`)
    return data
}
