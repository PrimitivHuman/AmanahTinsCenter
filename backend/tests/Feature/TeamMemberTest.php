<?php

namespace Tests\Feature;

use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class TeamMemberTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private string $adminToken;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'email' => 'admin@amanahtins.id',
            'password' => Hash::make('password123'),
        ]);

        $this->adminToken = $this->admin->createToken('admin-test-token')->plainTextToken;
    }

    public function test_public_visitor_can_list_active_team_members_with_explicit_category(): void
    {
        TeamMember::create([
            'name' => 'Annisa Larasati, A.Md.TW',
            'role' => 'Terapi Wicara (TW)',
            'category' => 'tw',
            'specialization' => 'Speech Delay',
            'is_active' => true,
            'order' => 1,
        ]);

        TeamMember::create([
            'name' => 'Dimas Bagaswara, S.Tr.Kes (OT)',
            'role' => 'Terapi Okupasi (OT)',
            'category' => 'ot',
            'specialization' => 'Motorik Halus',
            'is_active' => true,
            'order' => 2,
        ]);

        $response = $this->getJson('/api/team');

        $response->assertStatus(200);
        $data = $response->json();

        $this->assertCount(2, $data);
        $this->assertEquals('tw', $data[0]['category']);
        $this->assertEquals('ot', $data[1]['category']);
    }

    public function test_inactive_team_members_are_hidden_from_public_list(): void
    {
        TeamMember::create([
            'name' => 'Terapis Aktif',
            'role' => 'Terapi Wicara (TW)',
            'category' => 'tw',
            'specialization' => 'Speech Delay',
            'is_active' => true,
            'order' => 1,
        ]);

        TeamMember::create([
            'name' => 'Terapis Non-Aktif / Cuti',
            'role' => 'Sensori Integrasi (SI)',
            'category' => 'si',
            'specialization' => 'Sensori Vestibular',
            'is_active' => false,
            'order' => 2,
        ]);

        $response = $this->getJson('/api/team');

        $response->assertStatus(200);
        $data = $response->json();

        $this->assertCount(1, $data);
        $this->assertEquals('Terapis Aktif', $data[0]['name']);
    }

    public function test_admin_can_create_team_member_with_explicit_category(): void
    {
        $payload = [
            'name' => 'Bambang Prasetyo, S.Ft, Ftr',
            'role' => 'Fisioterapi Pediatrik (FT)',
            'category' => 'ft',
            'edu' => 'Profesi Fisioterapi UI',
            'specialization' => 'Motorik Kasar & Keseimbangan',
            'experience_years' => '5+ Tahun',
            'schedule' => 'Senin - Jumat',
            'str_number' => 'STR.15.02.1.2.21-08991',
            'bio' => 'Dedikasi melatih koordinasi fisik anak.',
            'philosophy' => 'Setiap langkah adalah awal kemandirian.',
            'tags' => ['Motorik Kasar', 'Postur'],
            'certifications' => ['Pediatric Physical Therapy'],
            'is_active' => true,
            'order' => 1,
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->adminToken)
            ->postJson('/api/admin/team', $payload);

        $response->assertStatus(201)
            ->assertJsonFragment(['message' => 'Anggota tim berhasil ditambahkan']);

        $member = TeamMember::where('name', 'Bambang Prasetyo, S.Ft, Ftr')->first();
        $this->assertNotNull($member);
        $this->assertEquals('ft', $member->category);
    }

    public function test_admin_cannot_create_team_member_with_invalid_category(): void
    {
        $payload = [
            'name' => 'Praktisi Tidak Valid',
            'role' => 'Role Tidak Valid',
            'category' => 'kategori_sembarangan',
            'specialization' => 'Spesialisasi',
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->adminToken)
            ->postJson('/api/admin/team', $payload);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['category']);
    }

    public function test_admin_can_update_team_member(): void
    {
        $member = TeamMember::create([
            'name' => 'Nama Awal',
            'role' => 'Terapi Wicara (TW)',
            'category' => 'tw',
            'specialization' => 'Speech Delay',
            'is_active' => true,
            'order' => 1,
        ]);

        $updatePayload = [
            'name' => 'Nama Baru, S.Tr.Kes',
            'role' => 'Sensori Integrasi (SI)',
            'category' => 'si',
            'specialization' => 'Sensori & Regulasi Emosi',
            'is_active' => false,
            'order' => 2,
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->adminToken)
            ->putJson('/api/admin/team/' . $member->id, $updatePayload);

        $response->assertStatus(200)
            ->assertJsonFragment(['message' => 'Data anggota tim berhasil diperbarui']);

        $updated = $member->fresh();
        $this->assertEquals('Nama Baru, S.Tr.Kes', $updated->name);
        $this->assertEquals('si', $updated->category);
        $this->assertFalse($updated->is_active);
    }

    public function test_admin_can_delete_team_member(): void
    {
        $member = TeamMember::create([
            'name' => 'Terapis Hendak Dihapus',
            'role' => 'Terapi Okupasi (OT)',
            'category' => 'ot',
            'specialization' => 'Motorik Halus',
            'is_active' => true,
        ]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->adminToken)
            ->deleteJson('/api/admin/team/' . $member->id);

        $response->assertStatus(200)
            ->assertJsonFragment(['message' => 'Anggota tim berhasil dihapus']);

        $this->assertDatabaseMissing('team_members', ['id' => $member->id]);
    }

    public function test_admin_can_upload_team_member_photo(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('therapist.webp', 600, 800)->size(500);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->adminToken)
            ->postJson('/api/admin/team/upload-image', [
                'image' => $file,
            ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['message', 'url']);

        $url = $response->json('url');
        $this->assertStringStartsWith('/storage/team/', $url);

        $storedPath = substr($url, strlen('/storage/'));
        Storage::disk('public')->assertExists($storedPath);
    }

    public function test_team_member_photo_upload_rejects_invalid_file_type(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->create('document.pdf', 300, 'application/pdf');

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->adminToken)
            ->postJson('/api/admin/team/upload-image', [
                'image' => $file,
            ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['image']);
    }
}
