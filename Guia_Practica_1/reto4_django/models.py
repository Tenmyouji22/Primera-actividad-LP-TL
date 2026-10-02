
class Estudiante(models.Model):
    # Más seguro: el ORM parametriza cada consulta por sí solo, así que los datos nunca se concatenan al SQL (sin inyección).
    # Más rápido de desarrollar: se usan objetos Python en vez de prepare/bind manual, y el mismo código sirve en PostgreSQL o MySQL.

    id = models.AutoField(primary_key=True)                # SERIAL PRIMARY KEY
    nombre = models.CharField(max_length=100)              # VARCHAR(100) NOT NULL
    correo = models.EmailField(max_length=150, unique=True)  # VARCHAR(150) NOT NULL UNIQUE
    edad = models.IntegerField()                           # INTEGER NOT NULL

    class Meta:
        db_table = "estudiantes"  # usa el mismo nombre de tabla del schema.sql
        ordering = ["nombre"]

    def __str__(self):
        return f"{self.nombre} ({self.correo})"

# Estudiante.objects.create(nombre="Ana Rodríguez", correo="ana@correo.com", edad=21)
