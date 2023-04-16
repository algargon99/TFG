import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable()
export class LaravelService {

  constructor(private http: HttpClient) { }

  // Obtener lista de usuarios
  getUsuarios(): Observable<any> {
    return this.http.get('http://tudominio.com/api/usuarios');
  }

  // Crear un nuevo usuario
  crearUsuario(usuario: any): Observable<any> {
    return this.http.post('http://tudominio.com/api/usuarios', usuario);
  }

  // Obtener detalle de un usuario por ID
  getUsuario(): Observable<any> {
    return this.http.get('http://tudominio.com/api/usuario');
  }

  // Actualizar un usuario por ID
  actualizarUsuario(usuario: any): Observable<any> {
    return this.http.put('http://tudominio.com/api/usuarios/', usuario);
  }

  // Eliminar un usuario por ID
  eliminarUsuario(usuario: any): Observable<any> {
    return this.http.delete('http://tudominio.com/api/usuarios/', usuario);
  }

  // Otras operaciones CRUD...
}
