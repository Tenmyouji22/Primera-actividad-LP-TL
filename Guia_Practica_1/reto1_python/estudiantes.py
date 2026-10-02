
class Estudiante:
    def __init__(self, nombre, promedio):
        self.nombre = nombre
        self.promedio = promedio

    def __str__(self):
        return f"{self.nombre} - promedio: {self.promedio:.2f}"


estudiantes = [
    Estudiante("Ana Rodríguez", 17.5),
    Estudiante("Luis Pérez", 12.0),
    Estudiante("María González", 15.3),
    Estudiante("Carlos Salazar", 14.0),
    Estudiante("Valentina Márquez", 19.1),
    Estudiante("José Hernández", 10.8),
]

destacados = list(filter(lambda e: e.promedio > 14, estudiantes))

print("Estudiantes con promedio mayor a 14:")
for estudiante in destacados:
    print(f"  - {estudiante}")
