<?php

namespace App\Models;

use CodeIgniter\Model;

class MensajeModel extends Model
{
    protected $table            = 'Mensajes';
    protected $primaryKey       = 'id_mensaje';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    protected $allowedFields    = ['id_emisor', 'id_receptor', 'texto', 'leido_at'];

    /**
     * Quién puede escribirse con quién:
     *  desarrollador <-> desarrollador  (sí)
     *  desarrollador <-> inversionista  (sí)
     *  inversionista <-> inversionista  (no)
     */
    public static function puedenChatear(?string $tipoA, ?string $tipoB): bool
    {
        $validos = ['desarrollador', 'inversionista'];

        if (! in_array($tipoA, $validos, true) || ! in_array($tipoB, $validos, true)) {
            return false;
        }

        return ! ($tipoA === 'inversionista' && $tipoB === 'inversionista');
    }

    /**
     * Mensajes entre dos usuarios.
     * Con $desdeId = 0 devuelve los últimos $limite; con $desdeId > 0 solo los posteriores a ese id.
     */
    public function entre(int $a, int $b, int $desdeId = 0, int $limite = 100): array
    {
        $this->groupStart()
                ->groupStart()->where('id_emisor', $a)->where('id_receptor', $b)->groupEnd()
                ->orGroupStart()->where('id_emisor', $b)->where('id_receptor', $a)->groupEnd()
            ->groupEnd();

        if ($desdeId > 0) {
            return $this->where('id_mensaje >', $desdeId)->orderBy('id_mensaje', 'ASC')->findAll($limite);
        }

        return array_reverse($this->orderBy('id_mensaje', 'DESC')->findAll($limite));
    }

    /** Pasa a "leído" todo lo que $deQuien le escribió a $paraQuien */
    public function marcarLeidos(int $deQuien, int $paraQuien): void
    {
        $this->db->table('Mensajes')
            ->where('id_emisor', $deQuien)
            ->where('id_receptor', $paraQuien)
            ->where('leido_at IS NULL', null, false)
            ->update(['leido_at' => date('Y-m-d H:i:s')]);
    }

    /** Cantidad de mensajes sin leer que tiene un usuario */
    public function noLeidos(int $paraQuien): int
    {
        return (int) $this->db->table('Mensajes')
            ->where('id_receptor', $paraQuien)
            ->where('leido_at IS NULL', null, false)
            ->countAllResults();
    }

    /** Bandeja: una fila por persona con quien hablo, con el último mensaje y los no leídos */
    public function conversacionesDe(int $yo): array
    {
        $mensajes = $this->db->prefixTable('Mensajes');
        $usuarios = $this->db->prefixTable('Usuario');

        $sql = "SELECT u.id_usuario, u.alias, u.tipo,
                       m.texto AS ultimo_texto, m.created_at AS ultima_fecha, m.id_emisor AS ultimo_emisor,
                       (SELECT COUNT(*) FROM {$mensajes} x
                         WHERE x.id_emisor = u.id_usuario AND x.id_receptor = ? AND x.leido_at IS NULL) AS no_leidos
                FROM {$mensajes} m
                INNER JOIN (
                    SELECT IF(id_emisor = ?, id_receptor, id_emisor) AS otro, MAX(id_mensaje) AS ultimo_id
                    FROM {$mensajes}
                    WHERE id_emisor = ? OR id_receptor = ?
                    GROUP BY otro
                ) c ON c.ultimo_id = m.id_mensaje
                INNER JOIN {$usuarios} u ON u.id_usuario = c.otro
                ORDER BY m.id_mensaje DESC";

        return $this->db->query($sql, [$yo, $yo, $yo, $yo])->getResultArray();
    }

    /** Forma en que viaja un mensaje hacia el navegador */
    public static function formatear(array $mensaje, int $yo): array
    {
        return [
            'id'    => (int) $mensaje['id_mensaje'],
            'mio'   => (int) $mensaje['id_emisor'] === $yo,
            'texto' => $mensaje['texto'],
            'hora'  => date('d/m H:i', strtotime($mensaje['created_at'])),
        ];
    }
}
